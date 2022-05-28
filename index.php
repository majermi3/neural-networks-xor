<?php
require 'vendor/autoload.php';

use Majernik\NeuralNetwork\NeuralNetwork;
use Majernik\NeuralNetwork\Model\Input;
use Majernik\NeuralNetwork\Model\Output;
use Majernik\NeuralNetwork\Model\HiddenLayer;
use Majernik\NeuralNetwork\Model\Neuron;

$epochs = 1000;
$inputs = [
    [0, 0],
//    [0, 1],
//    [1, 0],
//    [1, 1]
];
$hiddenLayers = [2, 1];
$expectedOutputs = [0]; //, 1, 1, 0

$network = new NeuralNetwork($inputs, $hiddenLayers, $expectedOutputs);
$network->build();
$network->train($epochs);
