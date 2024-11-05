let currentPage = 1;
let loading = false;
let hasMore = true;

function loadMoreResults() {
    if (loading || !hasMore) return;
    
    loading = true;
    const spinner = document.getElementById('loading-spinner');
    spinner.classList.remove('hidden');
    
    const query = document.getElementById('search-dropdown').value;
    const category = document.querySelector('#dropdown-button').textContent.trim();
    
    fetch(`/search?query=${query}&category=${category}&page=${++currentPage}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('search-results').insertAdjacentHTML('beforeend', data.html);
        hasMore = data.hasMore;
        loading = false;
        spinner.classList.add('hidden');
    });
}

// Infinite scroll detection
window.addEventListener('scroll', () => {
    if ((window.innerHeight + window.scrollY) >= document.documentElement.scrollHeight - 100) {
        loadMoreResults();
    }
});