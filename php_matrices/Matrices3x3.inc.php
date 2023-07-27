<?php
//------------------------------------------------------------------------------------------------------------------------
// Matrices 3x3
//------------------------------------------------------------------------------------------------------------------------
namespace php_matrices;
//------------------------------------------------------------------------------------------------------------------------
require_once('.root');

use php_matrices\Matrices2x2;
//------------------------------------------------------------------------------------------------------------------------
class Matrices3x3 {
	
	public static function identity(): array {
		// returns identity matrix
		return [
			[1.0, 0.0, 0.0],
			[0.0, 1.0, 0.0],
			[0.0, 0.0, 1.0]
		];
	}
	
	public static function scale(float $x = 1.0, float $y = 1.0): array {
		// returns scale matrix
		return [
			[$x, 0.0, 0.0],
			[0.0, $y, 0.0],
			[0.0, 0.0, 1.0]
		];
	}

	public static function translate(float $x = 0.0, float $y = 0.0): array {
		// returns translate matrix
		return [
			[1.0, 0.0, $x],
			[0.0, 1.0, $y],
			[0.0, 0.0, 1.0]
		];
	}

	public static function rotate(float $a_deg, float $x = 0.0, float $y = 0.0): array {
		// returns rotation matrix
		if($x || $y) {
			$translate_matrix = static::translate($x, $y);
			$rotate_matrix = static::rotate($a_deg);
			$final_matrix = static::multiply($translate_matrix, $rotate_matrix);
			$translate_matrix = static::translate(-$x, -$y);
			$final_matrix = static::multiply($final_matrix, $translate_matrix);
			return $final_matrix;
		} else {
			$a_rad = $a_deg * M_PI / 180.0;
			return [
				[cos($a_rad), -sin($a_rad), 0.0],
				[sin($a_rad), cos($a_rad), 0.0],
				[0.0, 0.0, 1.0]
			];	
		}
	}

	public static function multiply(array $matrix_a, array $matrix_b): array {
		// multiply 2 matrices
		return [
			[
				$matrix_a[0][0] * $matrix_b[0][0] + $matrix_a[0][1] * $matrix_b[1][0] + $matrix_a[0][2] * $matrix_b[2][0],
				$matrix_a[0][0] * $matrix_b[0][1] + $matrix_a[0][1] * $matrix_b[1][1] + $matrix_a[0][2] * $matrix_b[2][1],
				$matrix_a[0][0] * $matrix_b[0][2] + $matrix_a[0][1] * $matrix_b[1][2] + $matrix_a[0][2] * $matrix_b[2][2]
			],
			[
				$matrix_a[1][0] * $matrix_b[0][0] + $matrix_a[1][1] * $matrix_b[1][0] + $matrix_a[1][2] * $matrix_b[2][0],
				$matrix_a[1][0] * $matrix_b[0][1] + $matrix_a[1][1] * $matrix_b[1][1] + $matrix_a[1][2] * $matrix_b[2][1],
				$matrix_a[1][0] * $matrix_b[0][2] + $matrix_a[1][1] * $matrix_b[1][2] + $matrix_a[1][2] * $matrix_b[2][2]
			],
			[
				$matrix_a[2][0] * $matrix_b[0][0] + $matrix_a[2][1] * $matrix_b[1][0] + $matrix_a[2][2] * $matrix_b[2][0],
				$matrix_a[2][0] * $matrix_b[0][1] + $matrix_a[2][1] * $matrix_b[1][1] + $matrix_a[2][2] * $matrix_b[2][1],
				$matrix_a[2][0] * $matrix_b[0][2] + $matrix_a[2][1] * $matrix_b[1][2] + $matrix_a[2][2] * $matrix_b[2][2]
			]
		];
	}

	public static function multiply_value(array $matrix, float $value): array {
		// multiply $matrix by $value
		return [
			[$matrix[0][0] * $value, $matrix[0][1] * $value, $matrix[0][2] * $value],
			[$matrix[1][0] * $value, $matrix[1][1] * $value, $matrix[1][2] * $value],
			[$matrix[2][0] * $value, $matrix[2][1] * $value, $matrix[2][2] * $value]
		];
	}

	public static function inverse(array $matrix) {
		// get inverse matrix from $matrix
		$det = static::det($matrix);
		if($det) {
			return static::multiply_value(static::adjoint($matrix), 1.0 / $det);
		}
		return NULL;
	}

	public static function minor(array $matrix): array {
		// get minor of the $matrix
		$m00 = [
			[$matrix[1][1], $matrix[1][2]],
			[$matrix[2][1], $matrix[2][2]]
		];
		$m01 = [
			[$matrix[1][0], $matrix[1][2]],
			[$matrix[2][0], $matrix[2][2]]
		];
		$m02 = [
			[$matrix[1][0], $matrix[1][1]],
			[$matrix[2][0], $matrix[2][1]]
		];
		$m10 = [
			[$matrix[0][1], $matrix[0][2]],
			[$matrix[2][1], $matrix[2][2]]
		];
		$m11 = [
			[$matrix[0][0], $matrix[0][2]],
			[$matrix[2][0], $matrix[2][2]]
		];
		$m12 = [
			[$matrix[0][0], $matrix[0][1]],
			[$matrix[2][0], $matrix[2][1]]
		];
		$m20 = [
			[$matrix[0][1], $matrix[0][2]],
			[$matrix[1][1], $matrix[1][2]]
		];
		$m21 = [
			[$matrix[0][0], $matrix[0][2]],
			[$matrix[1][0], $matrix[1][2]]
		];
		$m22 = [
			[$matrix[0][0], $matrix[0][1]],
			[$matrix[1][0], $matrix[1][1]]
		];
		return [
			[Matrices2x2::det($m00), Matrices2x2::det($m01), Matrices2x2::det($m02)],
			[Matrices2x2::det($m10), Matrices2x2::det($m11), Matrices2x2::det($m12)],
			[Matrices2x2::det($m20), Matrices2x2::det($m21), Matrices2x2::det($m22)]
		];
	}

	public static function cofactor(array $matrix): array {
		// get cofactor matrix from $matrix
		return [
			[$matrix[0][0], -$matrix[0][1], $matrix[0][2]],
			[-$matrix[1][0], $matrix[1][1], -$matrix[1][2]],
			[$matrix[2][0], -$matrix[2][1], $matrix[2][2]]
		];
	}


	public static function transpose(array $matrix): array {
		// get transpose matrix from $matrix
		return [
			[$matrix[0][0], $matrix[1][0], $matrix[2][0]],
			[$matrix[0][1], $matrix[1][1], $matrix[2][1]],
			[$matrix[0][2], $matrix[1][2], $matrix[2][2]]
		];
	}

	public static function adjoint(array $matrix): array {
		// get adjoint matrix from $matrix
		$minor = static::minor($matrix);
		$cofactor = static::cofactor($minor);
		return static::transpose($cofactor);
	}

	public static function det(array $matrix): float {
		// get $matrix determenant
		//	https://en.wikipedia.org/wiki/Determinant
		return $matrix[0][0] * $matrix[1][1] * $matrix[2][2]
			+ $matrix[0][1] * $matrix[1][2] * $matrix[2][0]
			+ $matrix[0][2] * $matrix[1][0] * $matrix[2][1]
			- $matrix[0][2] * $matrix[1][1] * $matrix[2][0]
			- $matrix[0][1] * $matrix[1][0] * $matrix[2][2]
			- $matrix[0][0] * $matrix[1][2] * $matrix[2][1];
	}
}
//------------------------------------------------------------------------------------------------------------------------
?>
