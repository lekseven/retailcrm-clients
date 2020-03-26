import $ from 'jquery';

const $clientAddresses = $('#client_addresses');
const removeAddressButtonHtml = '<a class="btn btn-danger js-remove-address" href="#">&times;</a>';

$clientAddresses.data('index', $clientAddresses.find('fieldset').length);

// add a remove button to each address
$clientAddresses.find('fieldset.form-group').each(function () {
    $(this).append($(removeAddressButtonHtml));
});

$('.js-add-address').on('click', function () {
    const prototype = $clientAddresses.data('prototype');
    const index = $clientAddresses.data('index');

    const $newForm = $(prototype.replace(/__name__/g, index));
    $newForm.append(removeAddressButtonHtml);
    $clientAddresses.append($newForm);

    $clientAddresses.data('index', index + 1);
});

$('body').on('click', '.js-remove-address', function () {
    $(this).closest('fieldset.form-group').remove();
});
