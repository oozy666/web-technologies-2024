const postEl = document.getElementById('post-content');
const commentsEl = document.getElementById('post-comments');

const params = new URLSearchParams(window.location.search);
const activeId = params.get('id');

if (!activeId) {
    postEl.innerHTML = '<p class="error-msg">Ошибка: идентификатор публикации не передан</p>';
} else {
    loadPostAndComments(activeId);
}

async function loadPostAndComments(id) {
    try {
        const postRes = await fetch(`https://jsonplaceholder.typicode.com/posts/${id}`);
        if (!postRes.ok) {
            throw new Error('Публикация не найдена');
        }
        const postData = await postRes.json();
        displayPost(postData);

        const commentsRes = await fetch(`https://jsonplaceholder.typicode.com/posts/${id}/comments`);
        if (!commentsRes.ok) {
            throw new Error('Не удалось загрузить комментарии');
        }
        const commentsData = await commentsRes.json();
        displayComments(commentsData);
    } catch (err) {
        postEl.innerHTML = `<p class="error-msg">Ошибка: ${err.message}</p>`;
    }
}

function displayPost(post) {
    postEl.innerHTML = `
        <h2 class="post-title">${post.title}</h2>
        <p class="post-body">${post.body}</p>
        <a class="back-link" href="index.html">← Вернуться к списку</a>
    `;
}

function displayComments(comments) {
    commentsEl.innerHTML = '<h3 class="comments-title">Комментарии к публикации:</h3>';
    
    comments.forEach(comment => {
        const node = document.createElement('div');
        node.className = 'comment-card';
        node.innerHTML = `
            <p class="comment-author"><strong>${comment.name}</strong> (${comment.email})</p>
            <p class="comment-text">${comment.body}</p>
        `;
        commentsEl.appendChild(node);
    });
}
