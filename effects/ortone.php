<?php
	class Majik_ortone extends MajikEffect {
		function process(Imagick $target) {
			$a = clone $target;
			$a->compositeImage($target, imagick::COMPOSITE_SCREEN,0,0);

			$b = clone $a;
			$b->blurImage(0,5);

			$b->setImageOpacity(0.5);

			$a->compositeImage($b, imagick::COMPOSITE_MULTIPLY,0,0);
			
			return $a;
		}
	}

	MajikBox::add( 'ortone', new Majik_ortone() );
?>
