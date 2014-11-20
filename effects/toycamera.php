<?php
	class Majik_toycamera extends MajikEffect {
		function process(Imagick $target) {
			$qr = $target->getQuantumRange();
                        $max = $qr['quantumRangeLong'];

			$a = clone $target;
			$b = clone $target;



			$a->colorizeImage('yellow', 0);
			$a->medianFilterImage(5);
			$a->setImageOpacity(0.3);

			$b->setImageOpacity(0.7);
			$b->compositeImage($a,imagick::COMPOSITE_BLEND,0,0);

			$blur = $target->getImageWidth() / 8;
			$cornerW = ( $target->getImageWidth() / -40 );
			$cornerH = ( $target->getImageHeight() / -40 );
			$b->setImageBackgroundColor('black');
			$b->vignetteImage(0,$blur,$cornerH,$cornerW);

			return $b;
		}
	}

	MajikBox::add( 'toycamera', new Majik_toycamera() );
?>
