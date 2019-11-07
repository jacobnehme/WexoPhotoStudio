/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

Echo.channel(`orders`)
    .listen('OrderLineStatusUpdated', (e) => {
        console.log(e['orderLine']);
        console.log(e['orderLine']['id']);
        console.log(e['orderLine']['status_id']);

        let label = $('#order-line-' + e['orderLine']['id'] + ' .status');
        switch (e['orderLine']['status_id']) {
            case 1:
                label.removeClass('btn-warning').addClass('btn-success').text('Approved...');
                break;
            case 2:
                label.removeClass('btn-success').addClass('btn-danger').text('Rejected...');
                break;
            case 3:
                label.removeClass('btn-danger').addClass('btn-success').text('Approved...');
                break;
        }
    });

Echo.channel(`orders`)
    .listen('PhotoUploaded', (e) => {
        console.log('Photo Uploaded');
        console.log(e['orderLine']['id']);
        console.log(e['path']);
        let photos = $('#order-line-' + e['orderLine']['id'] + ' .photos');
        photos.html(photos.html() +
            '<div class="col-md-3">' +
            '<div class="photo" data-toggle="modal" data-target="#modal-' + e['orderLine']['id'] + '">' +
            '<img class="img img-fluid" src="http://127.0.0.1:8000/images/' + e['path'] + '">' +
            '</div>' +
            '</div>'
        );
        $('#status-form-' + e['orderLine']['id']).show();
    });
