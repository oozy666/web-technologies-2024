const postsEl = document.getElementById('posts-container');
const pagesEl = document.getElementById('pages-container');

const LIMIT = 10;
let pageActive = 1;
let allPosts = [];

async function loadPostsList() {
    try {
        const res = await fetch('https://jsonplaceholder.typicode.com/posts');
        if (!res.ok) {
            throw new Error('Не удалось загрузить публикации');
        }
        allPosts = await res.json();
        renderPostsList();
        renderPagesList();
    } catch (err) {
        postsEl.innerHTML = `<p class="error-msg">Произошла ошибка: ${err.message}</p>`;
    }
}

function renderPostsList() {
    postsEl.innerHTML = '';
    const offset = (pageActive - 1) * LIMIT;
    const paginated = allPosts.slice(offset, offset + LIMIT);

    paginated.forEach(post => {
        const item = document.createElement('div');
        item.className = 'post-item';
        item.innerHTML = `
            <h3 class="post-item__title">${post.title}</h3>
            <p class="post-item__body">${post.body}</p>
            <a class="post-item__link" href="post.html?id=${post.id}">Подробнее</a>
        `;
        postsEl.appendChild(item);
    });
}

function renderPagesList() {
    pagesEl.innerHTML = '';
    const total = Math.ceil(allPosts.length / LIMIT);

    for (let i = 1; i <= total; i++) {
        const btn = document.createElement('button');
        btn.textContent = i;
        btn.className = 'catalog__pagination-item';
        if (i === pageActive) {
            btn.classList.add('catalog__pagination-item_active');
            btn.disabled = true;
        }
        btn.addEventListener('click', () => {
            pageActive = i;
            renderPostsList();
            renderPagesList();
        });
        pagesEl.appendChild(btn);
    }
}

loadPostsList();
