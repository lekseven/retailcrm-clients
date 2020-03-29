import $ from 'jquery';

const $clientAddresses = $('#client_addresses');

$clientAddresses.data('index', $clientAddresses.find('fieldset').length);

$('.js-add-address').on('click', function () {
    const prototype = $clientAddresses.data('prototype');
    const index = $clientAddresses.data('index');

    const newForm = prototype.replace(/__name__/g, index);
    $clientAddresses.append(newForm);

    $clientAddresses.data('index', index + 1);
});

$('body').on('click', '.js-remove-address', function () {
    $(this).closest('fieldset').remove();
});
