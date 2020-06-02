<?php
require 'app/Inlet.php';

Api::route('/', function(){Api::render('index', array('title' => '测试接口',));});

Api::start();