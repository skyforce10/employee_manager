require('./bootstrap');

import $ from 'jquery';
import 'select2/dist/css/select2.min.css';
import 'select2';

import Chart from 'chart.js/auto';


$(document).ready(function() {
    $('.select2').select2();
});