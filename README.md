# PHP Matrices

Classes for working with matrices on PHP.

Module operates with common arrays as matrices.

    $matrix = [
        [1.0, 0.0, 0.0],
        [0.0, 1.0, 0.0],
        [0.0, 0.0, 1.0]
    ];

Usage
-

Add module autoload to your .php file

    require_once('.php_matrices_autoload');

Call "use" to initiate matrices classes

    use php_matrices\Matrices3x3;

Now you can use this class. For example:

Get translate matrix to point wit coordinates x = 5, y = 10:

    $translate_matrix = Matrices3x3::translate(5, 10);
    var_dump($translate_matrix);

    // array(3) { [0]=> array(3) { [0]=> float(1) [1]=> float(0) [2]=> float(5) } [1]=> array(3) { [0]=> float(0) [1]=> float(1) [2]=> float(10) } [2]=> array(3) { [0]=> float(0) [1]=> float(0) [2]=> float(1) } }

Multiply two matrices to get combined transformations:

    $translate_matrix = Matrices3x3::translate(5, 10);
    $scale_matrix = Matrices3x3::scale(1.5, 2.0);
    $joined_matrix = Matrices3x3::multiply($translate_matrix, $scale_matrix);
    var_dump($joined_matrix);

    // array(3) { [0]=> array(3) { [0]=> float(1.5) [1]=> float(0) [2]=> float(5) } [1]=> array(3) { [0]=> float(0) [1]=> float(2) [2]=> float(10) } [2]=> array(3) { [0]=> float(0) [1]=> float(0) [2]=> float(1) } }
