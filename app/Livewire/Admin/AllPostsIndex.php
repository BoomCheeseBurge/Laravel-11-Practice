<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AllPostsIndex extends Component
{
    use WithPagination, LivewireAlert;

    /**
     * Table Tools
     */
    #[Url(as: 's', history: true)]
    public string $search = ''; // Store search keyword

    public int $perPage = 10; // Display records per page

    #[Locked]
    public string $sortHeader = 'updated_at'; // Store the current sorted by column
    #[Locked]
    public string $sortDirection = 'desc'; // Store the current sort direction
    protected $queryString = [ // Add a query string to the URL to indicate which column and direction is currently sorted by
        'sortHeader'  => ['keep' => true], // Include the query string even on first page load
        'sortDirection' => ['keep' => true] // Include the query string even on first page load
    ];

    public array $selectedRecords = []; // Store record IDs to be bulk deleted
    public bool $selectCurrentPage = false; // Determine whether the records in the current page are all selected
    public bool $selectAll = false; // Determine whether the all records are selected
    public Collection $categories; // Store the categories from the database
    public ?int $selectedCategory = null; // Store the selected category

    /**
     * Table Info
     */
    #[Locked]
    public string $title = 'Admin';
    #[Locked]
    public string $subTitle = 'Admin Posts';
    #[Locked]
    public array $columns = [
                                'Bulk',
                                'Number',
                                'Author',
                                'Title',
                                'Slug',
                                'Category',
                                'Date Created',
                                'Action'
                            ];

    /**
     * Action Column
     */
    public Post $selectedPost;

    /**
     * Trashed Table
     */
    public bool $archive = false; // Determines whether to switch to archive records

    // ---------------------------------------------------------------- || ----------------------------------------------------------------

    /**
     * Data passed into components is received through the mount() lifecycle hook as method parameters
     */
    public function mount()
    {
        $this->categories = Category::get();
    }

    /**
     * Retrieve the models for this table
     */
    #[Computed()]
    public function loadData() // Retrieve the table records
    {
        if(!empty($this->search)) // Validate search keyword if exist
        {
            if ((!preg_match_all('/^[\p{L}\p{M}\p{P}\d]+(?:\s[\p{L}\p{M}\p{P}\d]+)*$/', $this->search)) && (strlen($this->search) <= 100)) {
                $this->search = '';
            }
        }

        return Post::join('categories', 'posts.category_id', '=', 'categories.id')
                ->join('users', 'posts.author_id', '=', 'users.id')
                ->when($this->archive, fn($query) => $query->onlyTrashed()) // Switch to archived posts
                ->select('posts.*', 'users.username', 'posts.created_at as Date Created', 'categories.name as category_name', 'categories.color as category_color')
                ->when($this->search, fn ($query) => $query->where('title', 'like', '%' . $this->search . '%')
                                                            ->orWhereHas('category', function (Builder $query) {
                                                                $query->where('name', 'like', "%$this->search%");
                                                            })->orWhereHas('author', function (Builder $query) {
                                                                $query->where('username', 'like', "%$this->search%");
                                                            })
                ) // Search query
                ->when($this->sortHeader === 'category', function ($query) {
                    return $query->orderBy('categories.name', $this->sortDirection); // Order by category name
                }, function ($query) {
                    return $query->orderBy($this->sortHeader, $this->sortDirection);
                })
                ->paginate($this->perPage);
    }

    /**
     * Reset to the first page when there is a search input,
     * otherwise, the page is stuck on wherever the page was before and the table data will not display correctly
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Sort column
     */
    public function sortBy(string $columnName)
    {
        $this->sortHeader === $columnName ?
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc' // Sort direction based on the clicked column name
            : $this->sortDirection = 'asc'; // Default sort direction

        $this->sortHeader = $columnName;
    }

    /**
     * Bulk remove selected records
     */
    public function removeSelected()
    {
        Post::whereIn('id', $this->selectedRecords)->delete(); // Remove the selected posts

        /**
         * Reset all variables
         */
        $this->reset(['selectCurrentPage', 'selectAll', 'selectedRecords']);

        $this->dispatch('hide-bulk'); // Hide the bulk dropdown

        // session()->flash('success', 'Posts successfully removed to archive!');

        $this->alert('success', 'Posts successfully removed to archive!', [
            'position' => 'center',
            'timer' => null,
            'showCloseButton' => true,
        ]);
    }

    /**
     * Bulk edit selected records
     */
    public function editSelected()
    {
        // Check if there is no selected category
        if($this->selectedCategory == null)
        {
            /**
             * Reset all variables
             */
            $this->reset(['selectCurrentPage', 'selectAll', 'selectedRecords']);

            $this->dispatch('hide-bulk'); // Hide the bulk dropdown

            // session()->flash('fail', 'Updated failed! No category was chosen for the bulk edit.');

            $this->alert('error', 'Updated failed! No category was chosen for the bulk edit.', [
                            'position' => 'center',
                            'timer' => null,
                            'showCloseButton' => true,
                        ]);

            return;
        }

        Post::whereIn('id', $this->selectedRecords)->update(['category_id' => $this->selectedCategory]); // Update the selected posts with the new category

        $this->resetPage(); // Reset to page 1

        $this->dispatch('hide-bulk'); // Hide the bulk dropdown

        /**
         * Reset all variables
         */
        $this->reset(['selectedCategory', 'selectCurrentPage', 'selectAll', 'selectedRecords']);

        // session()->flash('success', 'Posts\' category successfully updated!');

        $this->alert('success', 'Posts\' category successfully updated!', [
                        'position' => 'center',
                        'timer' => null,
                        'showCloseButton' => true,
                    ]);
    }

    /**
     * Bulk permanent delete selected records
     */
    public function deleteSelected()
    {
        Post::whereIn('id', $this->selectedRecords)->forceDelete(); // Delete the selected posts

        /**
         * Reset all variables
         */
        $this->reset(['selectCurrentPage', 'selectAll', 'selectedRecords']);

        $this->dispatch('hide-bulk'); // Hide the bulk dropdown

        // session()->flash('success', 'Posts permanently deleted!');

        $this->alert('success', 'Posts permanently deleted!', [
            'position' => 'center',
            'timer' => null,
            'showCloseButton' => true,
        ]);
    }

    /**
     * Bulk restore selected records
     */
    public function restoreSelected()
    {
        Post::whereIn('id', $this->selectedRecords)->restore(); // Restore the selected posts

        /**
         * Reset all variables
         */
        $this->reset(['selectCurrentPage', 'selectAll', 'selectedRecords', 'archive']);

        $this->dispatch('hide-bulk'); // Hide the bulk dropdown

        // session()->flash('success', 'Posts successfully restored!');

        $this->alert('success', 'Posts successfully restored!', [
            'position' => 'center',
            'timer' => null,
            'showCloseButton' => true,
        ]);
    }

    /**
     * Select all records
     */
    public function getAllRecords() { return Post::pluck('id')->toArray(); }

    /**
     * Select records in current page
     */
    public function getCurrentPageRecords() { return $this->loadData()->pluck('id')->toArray(); }

    /**
     * Livewire Pagination Hook
     */
    public function updatedPage()
    {
        // On the next page, reset bulk selection
        $this->reset(['selectCurrentPage', 'selectAll', 'selectedRecords']);
    }

    /**
     * Retrieve modal based on slug
     */
    public function getPostSlug(Post $post)
    {
        $this->selectedPost = $post;
    }

    /**
     * Find trashed post
     */
    public function getTrashedPost(string $slug)
    {
        $this->selectedPost = Post::onlyTrashed()->where('slug', $slug)->firstOrFail();
    }

    /**
     * Remove single post
     */
    public function removeSinglePost()
    {
        $this->selectedPost->delete();

        session()->flash('success', 'Post successfully removed! Check archived posts.');
    }

    /**
     * Restore single post
     */
    public function restoreSinglePost()
    {
        $this->selectedPost->restore();

        $this->archive = false;

        session()->flash('success', 'Post successfully restored!');
    }

    /**
     * Delete single post
     */
    public function deleteSinglePost()
    {
        $this->selectedPost->forceDelete();

        session()->flash('success', 'Post permanently deleted!');
    }

    /**
     * Runs after the page is updated for this component
     */
    public function updatedPaginators($page, $pageName)
    {
        $this->dispatch('resetResizeColumn');
    }

    public function render()
    {
        $this->dispatch('reinitTooltips');

        return view('livewire.admin.all-posts-index', [
                        'columns' => $this->columns,
                        'records' => $this->loadData(),
                    ])
                    ->layout('components.layouts.app', [
                        'title' => 'Admin',
                        'page' => 'allPosts',
                    ]);
    }
}