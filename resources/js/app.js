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

$('.order-line form.status-form button').on('click', function () {

    let p = $(this).siblings('input[name="photos[]"]');
    let photos = [];
    for (let i = 0; i < p.length; i++) {
        photos.push(p[i].value);
    }

    $.ajax({
        type: 'POST',
        url: '/orderLines/' + $(this).attr('data-id'),
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            _method: "PATCH",
            status_id: $(this).attr('data-status'),
            photos: photos,
        },
        success: function (data) {
            console.log(data);
        }
    });
});

Echo.channel(`orders`)
    .listen('OrderLineStatusUpdated', (e) => {

        // $.ajax(
        //     {
        //         url: "/orders/showAsync/1",
        //         type: 'GET',
        //     }).done(
        //     function (data) {
        //         console.log(data.html.querySelector('#order-line-' + e['orderLine']['id']));
        //     }
        // );

        let label = $('#order-line-' + e['orderLine']['id'] + ' .status-label');
        let content = $('#order-line-' + e['orderLine']['id'] + ' .content');
        let buttons = $('#order-line-' + e['orderLine']['id'] + ' .status-form');
        let toggle = $('#order-line-' + e['orderLine']['id'] + ' .toggle');

        label.removeClass(function (index, className) {
            return (className.match(/(^|\s)btn-\S+/g) || []).join(' ');
        });

        switch (e['orderLine']['status_id']) {
            case 1:
                label.addClass('btn-warning').text('Pending...');
                $('#order-line-' + e['orderLine']['id'] + ' .show').hide();
                break;
            case 2:
                label.addClass('btn-primary').text('Active...');
                $('#order-line-' + e['orderLine']['id'] + ' .hide').show();
                buttons.show();
                break;
            case 3:
                label.addClass('btn-danger').text('Rejected...');
                content.hide();
                buttons.hide();
                break;
            case 4:
                label.addClass('btn-success').text('Approved...');
                content.hide();
                buttons.hide();
                break;
            case 5:
                label.addClass('btn-success').text('Pre-approved...');
                content.hide();
                buttons.hide();
                toggle.show();
                break;
        }

        // $('.notifications').html($('.notifications').html() +
        //     '<p>' +
        //     'Status on #' +
        //     e['orderLine']['id'] +
        //     ' updated.' +
        //     '</p><br>'
        // );
    });

Echo.channel(`orders`)
    .listen('PhotoUploaded', (e) => {

        let photosHTML = '';
        let indicatorsHTML = '';
        let modalsHTML = '';
        for (let i = 0; i < e['fileNames'].length; i++) {
            let active;
            if (i === 0) {
                active = 'active';
            }
            photosHTML +=
                '<div class="col-md-3">' +
                '<div class="photo" data-toggle="modal" data-target="#modal-' + e['orderLine']['id'] + '">' +
                '<img class="img img-fluid" src="http://127.0.0.1:8000/images/' + e['fileNames'][i] + '">' +
                '</div>' +
                '</div>';
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

        // $('.notifications').html($('.notifications').html() +
        //     '<p>' +
        //     'Photos uploaded to #' +
        //     e['orderLine']['id'] +
        //     '</p><br>'
        // );
    });
