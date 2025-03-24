import './bootstrap';

import Alpine from 'alpinejs';
import '../sass/admin_index.scss';

// // ページごとに異なるSCSSを適用
// const page = document.body.dataset.page; // 各 Blade に `data-page` を設定
//
// if (page === 'home') {
//     import('../scss/home.scss');
// } else if (page === 'dashboard') {
//     import('../scss/dashboard.scss');
// } else if (page === 'admin') {
//     import('../scss/admin.scss');
// } else if (page === 'users') {
//     import('../scss/users.scss');
// } else if (page === 'login') {
//     import('../scss/login.scss');
// }

window.Alpine = Alpine;

Alpine.start();
