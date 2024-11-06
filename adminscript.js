console.log()

    document.addEventListener("DOMContentLoaded", function() {
        // Fetch reviews from reviews.php
        fetch('adminreviews.php')
            .then(response => response.json())
            .then(data => displayReviews(data))
            .catch(error => console.error('Error:', error));

        function displayReviews(reviews) {
            const reviewsSection = document.getElementById('reviews');

            reviews.forEach(review => {
                const reviewDiv = document.createElement('div');
                reviewDiv.className = 'review';
                reviewDiv.innerHTML = `
                    <h4>Отзыв пользователя <span class="bold">${review.username} </span></h4>
                  
                    <div class="rating">${createStars(review.rating)}</div>
                    <div class="buttons">
                        <button class="view-button" data-id="${review.id}">Просмотреть отзыв</button>
                        <button class="approve-button" data-id="${review.id}" data-actual="${review.actual}">${review.actual == 1 ? 'Снять отзыв' : 'Допустить отзыв'}</button>
                        <button class="deletereview-button" data-id="${review.id}">Полностью удалить отзыв</button>
                        </div>
                        <hr>
                `;

                reviewsSection.appendChild(reviewDiv);
            });
        }

        // Create star elements based on rating
        function createStars(rating) {
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= rating) {
                    stars += '<span class="star selected">&#9733;</span>';
                } else {
                    stars += '<span class="star">&#9733;</span>';
                }
            }
            return stars;
        }
// Add event listener for delete button
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('deletereview-button')) {
        const reviewId = event.target.dataset.id;
        // Show a confirmation dialog before deleting the review
        if (confirm('Вы уверены, что хотите удалить этот отзыв?')) {
            // Send a request to the server to delete the review
            fetch('delete_review.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${reviewId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the review from the page
                    event.target.closest('.review').remove();
                }
            });
        }
    }
});
        // Add event listeners for view and approve buttons
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('view-button')) {
        const reviewId = event.target.dataset.id;
        window.location.href = `review.php?id=${reviewId}`;
    } else if (event.target.classList.contains('approve-button')) {
        const reviewId = event.target.dataset.id;
        const isApproved = event.target.dataset.actual == 1 ? 0 : 1;
        // Send a request to the server to update the review's approval status
        fetch('admin_dashboard.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${reviewId}&actual=${isApproved}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                event.target.dataset.actual = isApproved;
                event.target.textContent = isApproved == 1 ? 'Снять отзыв' : 'Допустить отзыв';
            }
        });
    }
});
    });
    
    
    
const productsTab = document.getElementById('tab1');
const servicesTab = document.getElementById('tab2');
const productsSection = document.getElementById('products');
const servicesSection = document.getElementById('services');

// Check local storage for the saved tab state
const savedTab = localStorage.getItem('tab');
if (savedTab === 'services') {
    servicesTab.checked = true;
    productsTab.checked = false;
    productsSection.style.display = 'none';
    servicesSection.style.display = 'block';
} else {
    productsTab.checked = true;
    servicesTab.checked = false;
    productsSection.style.display = 'block';
    servicesSection.style.display = 'none';
}

function fetchItems(category) {
    fetch(`items-api-admin.php?category=${category}`)
        .then(response => response.json())
        .then(data => {
            console.log('Data received:', data);
            const section = category === 'Производимые товары' ? productsSection : servicesSection;
            section.innerHTML = '';
             data.forEach(item => {
            const itemDiv = document.createElement('div');
            itemDiv.innerHTML = `
            <h3>${item.title}</h3>
            ${item.image_url ? `<img src="${item.image_url}" alt="${item.title}" style="max-width: 100%;">` : ''}
            <p>${item.content}</p>
            <button onclick="editItem(${item.id})">Редактировать</button>
            <button onclick="deleteItem(${item.id})">Удалить</button>
            <label>
                <input type="checkbox" class="custom-checkbox" ${item.actual ? 'checked' : ''} onclick="togglePublish(${item.id})"> Опубликовано
            </label>
        `;
                section.appendChild(itemDiv);
                const hr = document.createElement('hr');
                section.appendChild(hr);
            });
        })
        .catch(error => console.error('Error:', error));
}

productsTab.addEventListener('change', () => {
    productsSection.style.display = 'block';
    servicesSection.style.display = 'none';
    fetchItems('Производимые товары');
    localStorage.setItem('tab', 'products'); // Save the tab state to local storage
});

servicesTab.addEventListener('change', () => {
    productsSection.style.display = 'none';
    servicesSection.style.display = 'block';
    fetchItems('Предлагаемые услуги');
    localStorage.setItem('tab', 'services'); // Save the tab state to local storage
});

fetchItems(savedTab === 'services' ? 'Предлагаемые услуги' : 'Производимые товары');

function editItem(id) {
    window.location.href = `edit_item?id=${id}`;
}

function togglePublish(id) {
    fetch(`toggle_publish?id=${id}`)
        .then(response => {
            if (response.ok) {
                fetchItems(productsTab.checked ? 'Производимые товары' : 'Предлагаемые услуги');
            } else {
                console.error('Error toggling publish status');
            }
        })
        .catch(error => console.error('Error:', error));
}

function deleteItem(id) {
    if (confirm('Вы точно хотите удалить эту публикацию?')) {
        fetch(`delete_item?id=${id}`)
            .then(response => {
                if (response.ok) {
                    fetchItems(productsTab.checked ? 'Производимые товары' : 'Предлагаемые услуги');
                } else {
                    console.error('Error deleting item');
                }
            })
            .catch(error => console.error('Error:', error));
    }
}
   


