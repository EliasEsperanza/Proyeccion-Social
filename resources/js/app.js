import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    const paginationItems = document.querySelectorAll('.pagination .page-item');
    const paginationWrapper = document.getElementById('paginationWrapper');
    let currentPage = 1;
    const totalPages = 5; 

    function updatePaginationBorder() {
        paginationWrapper.classList.add('active-border');
    }

    function handlePageChange(page) {
        if (page === 'next') {
            if (currentPage < totalPages) {
                currentPage++;
            }
        } else {
            currentPage = parseInt(page);
        }
        paginationItems.forEach(item => item.classList.remove('active'));
        document.querySelector(`.page-item[data-page="${currentPage}"]`).classList.add('active');
        updatePaginationBorder();
    }

    paginationItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const page = item.getAttribute('data-page');
            handlePageChange(page);
        });
    });

    updatePaginationBorder(); 
});