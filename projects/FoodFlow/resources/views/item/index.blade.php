<div class="min-h-screen bg-brandDark"
     x-data="foodSearch()"
     x-init="init()"
     @search-updated.debounce.300ms="params.search = $event.detail; fetchResults()"
     @filter-changed.debounce.150ms="params = $event.detail; fetchResults()">

    <x-search :categories="$categories" :locations="$locations" />

    <div x-show="loading" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none;">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-brandIndigo border-t-transparent"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div id="food-items-container" x-html="results">
            @include('item.partials.items', ['foodItems' => $foodItems])
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('foodSearch', () => ({
                loading: false,
                results: '',
                params: {
                    search: '',
                    category: '',
                    location: ''
                },

                init() {
                    const urlParams = new URLSearchParams(window.location.search);
                    this.params = {
                        search: urlParams.get('search') || '',
                        category: urlParams.get('category') || '',
                        location: urlParams.get('location') || ''
                    };
                    this.fetchResults();
                },

                async fetchResults(url = null) {
                    this.loading = true;
                    try {
                        const currentParams = {
                            search: encodeURIComponent(this.params.search),
                            category: encodeURIComponent(this.params.category),
                            location: encodeURIComponent(this.params.location)
                        };

                        const queryString = new URLSearchParams(currentParams).toString();
                        const requestUrl = url || `{{ route('dashboard') }}?${queryString}`;

                        const response = await fetch(requestUrl, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        });

                        this.results = await response.text();
                        history.replaceState(null, '', requestUrl);
                    } catch (error) {
                        console.error('Fehler:', error);
                    } finally {
                        this.loading = false;
                    }
                }
            }));
        });

        document.addEventListener('click', (e) => {
            const paginationLink = e.target.closest('.pagination a');
            if (paginationLink) {
                e.preventDefault();
                Alpine.$data(document.querySelector('[x-data="foodSearch()"]')).fetchResults(paginationLink.href);
            }
        });
    </script>
</div>
