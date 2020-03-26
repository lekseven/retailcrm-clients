import $ from 'jquery';

const $clientAddresses = $('#client_addresses');

$clientAddresses.data('index', $clientAddresses.find('fieldset').length);

// add a remove button to each address
$clientAddresses.find('fieldset.form-group').each(function () {
    $(this).append($('<a class="btn btn-danger js-remove-address" href="#">&times;</a>'));
});

$('.js-add-address').on('click', function () {
    const prototype = $clientAddresses.data('prototype');
    const index = $clientAddresses.data('index');

    $clientAddresses.data('index', index + 1);

    $clientAddresses.append(prototype.replace(/__name__/g, index));
});

$('.js-remove-address').on('click', function () {
    $(this).closest('fieldset.form-group').remove();
});
