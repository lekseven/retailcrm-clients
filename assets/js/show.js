import $ from "jquery";
import 'bootstrap';

$('#tab_panel a').on('click', function (e) {
    e.preventDefault();
    $(this).tab('show');
});
