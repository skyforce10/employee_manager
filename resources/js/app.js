require('./bootstrap');

import $ from 'jquery';
import 'select2/dist/css/select2.min.css';
import 'select2';

$(document).ready(function() {
    $('.select2').select2();
});