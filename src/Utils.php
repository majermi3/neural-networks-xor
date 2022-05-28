<?php
namespace Majernik\NeuralNetwork;

class Utils
{
    /**
     * Returns value in interval <0,1>
     */
    public static function normalize($value): float
    {
        return 1 / (1 + exp(-$value));
    }

    public static function derivativeSigmoid($value): float
    {
        return $value * (1 - $value);
    }

    public static function random(): float
    {
        return (float)rand() / (float)getrandmax();
    }
}
