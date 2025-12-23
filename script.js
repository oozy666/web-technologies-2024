if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init)
} else {
    init()
}

function init() {
    const data = {
        name: 'Каталог товаров',
        hasChildren: true,
        checked: false,
        items: [
            {
                name: 'Мойки',
                hasChildren: true,
                checked: false,
                items: [
                    {
                        name: 'Ulgran',
                        hasChildren: true,
                        checked: true,
                        items: [
                            {
                                name: 'Smth',
                                hasChildren: false,
                                checked: false
                            },
                            {
                                name: 'Smth',
                                hasChildren: false,
                                checked: false
                            }
                        ]
                    },
                    {
                        name: 'Vigro Mramor',
                        hasChildren: false,
                        checked: false
                    },
                    {
                        name: 'Handmade',
                        hasChildren: true,
                        checked: true,
                        items: [
                            {
                                name: 'Smth',
                                hasChildren: false,
                                checked: false
                            },
                            {
                                name: 'Smth',
                                hasChildren: false,
                                checked: false
                            }
                        ]
                    },
                    {
                        name: 'Vigro Glass',
                        hasChildren: false,
                        checked: false
                    }
                ]
            },
            {
                name: 'Фильтры',
                hasChildren: true,
                checked: false,
                items: [
                    {
                        name: 'Ulgran',
                        hasChildren: true,
                        checked: true,
                        items: [
                            {
                                name: 'Smth',
                                hasChildren: false,
                                checked: false
                            },
                            {
                                name: 'Smth',
                                hasChildren: false,
                                checked: false
                            }
                        ]
                    },
                    {
                        name: 'Vigro Mramor',
                        hasChildren: false,
                        checked: false
                    }
                ]
            }
        ]
    }

    const items = new ListItems(document.getElementById('list-items'), data)
    items.render()
    items.init()

    function ListItems(el, data) {
        this.el = el;
        this.data = data;

        this.init = function () {
            this.el.addEventListener('click', (event) => {
                // Клик на стрелку
                if (event.target.classList.contains('list-item__arrow')) {
                    const parent = event.target.closest('[data-parent]');
                    if (parent) {
                        this.toggleItems(parent);
                    }
                }
            });
        }

        this.renderParent = function (data, level = 0) {
            const parentAttr = data.hasChildren ? 'data-parent' : '';
            const baseClass = level === 0 ? 'list-item list-item_open' : 'list-item';
            
            let html = `<div class="${baseClass}" ${parentAttr}>`;
            html += `<div class="list-item__inner">`;
            
            if (data.hasChildren) {
                html += `<img class="list-item__arrow" src="img/chevron-down.png" alt="chevron-down">`;
            } else {
                html += `<span style="display: inline-block; width: 1em;"></span>`;
            }
            
            html += `<img class="list-item__folder" src="img/folder.png" alt="folder">`;
            
            const checkedAttr = data.checked ? 'checked' : '';
            html += `<input type="checkbox" ${checkedAttr}>`;
            
            html += `<span>${data.name}</span>`;
            html += `</div>`;
            
            if (data.hasChildren && data.items && data.items.length > 0) {
                html += `<div class="list-item__items">`;
                data.items.forEach(item => {
                    html += this.renderParent(item, level + 1);
                });
                html += `</div>`;
            }
            
            html += `</div>`;
            return html;
        }

        this.render = function () {
            this.el.innerHTML = this.renderParent(this.data);
        }

        this.toggleItems = function (parent) {
            parent.classList.toggle('list-item_open');
        }
    }
}