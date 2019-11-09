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

//Toggle Button
$('.order-line .toggle').on('click', function () {
    $('#order-line-' + $(this).attr('data-id') + ' > .content').toggle();
});

Echo.channel(`orders`)
    .listen('OrderLineStatusUpdated', (e) => {

        let label = $('#order-line-' + e['orderLine']['id'] + ' .status-label');
        switch (e['orderLine']['status_id']) {
            case 1:
                label.removeClass(function (index, className) {
                    return (className.match(/(^|\s)btn-\S+/g) || []).join(' ');
                }).addClass('btn-warning').text('Pending...');
                break;
            case 2:
                label.removeClass(function (index, className) {
                    return (className.match(/(^|\s)btn-\S+/g) || []).join(' ');
                }).addClass('btn-primary').text('Active...');

                $('#order-line-' + e['orderLine']['id'] + ' .hide').show();
                break;
            case 3:
                label.removeClass('btn-primary').addClass('btn-danger').text('Rejected...');
                break;
            case 4:
                label.removeClass('btn-primary').addClass('btn-success').text('Approved...');
                $('#order-line-' + e['orderLine']['id'] + ' .content').hide();
                break;
            case 5:
                label.removeClass(function (index, className) {
                    return (className.match(/(^|\s)btn-\S+/g) || []).join(' ');
                }).addClass('btn-success').text('Pre-approved...');
                $('#order-line-' + e['orderLine']['id'] + ' .content').hide();
                break;
        }
    });

Echo.channel(`orders`)
    .listen('PhotoUploaded', (e) => {

        let photosHTML = '';
        let indicatorsHTML = '';
        let modalsHTML = '';
        for (let i = 0; i < e['fileNames'].length; i++) {
            photosHTML +=
                '<div class="col-md-3">' +
                '<div class="photo" data-toggle="modal" data-target="#modal-' + e['orderLine']['id'] + '">' +
                '<img class="img img-fluid" src="http://127.0.0.1:8000/images/' + e['fileNames'][i] + '">' +
                '</div>' +
                '</div>';
            let active;
            if (i === 0){
                active = 'active';
            }
            indicatorsHTML +=
                '<li data-target="carousel-' + e['orderLine']['id'] + '" ' +
                'data-slide-to="' + i + '" ' +
                'class="' + active + '"></li>';
            modalsHTML +=
                '<div class="carousel-item ' + active + '">' +
                '<div class="photo">' +
                '<img class="img img-fluid" src="http://127.0.0.1:8000/images/' + e['fileNames'][i] + '">' +
                '</div>' +
                '</div>';
        }

        $('#order-line-' + e['orderLine']['id'] + ' .photos').html(photosHTML);
        $('#order-line-' + e['orderLine']['id'] + ' .carousel-indicators').html(indicatorsHTML);
        $('#order-line-' + e['orderLine']['id'] + ' .carousel-inner').html(modalsHTML);
    });
