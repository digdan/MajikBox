<?php
	class Majik_enrich extends MajikEffect {
		function process(Imagick $target) {

			//Presets
			$radA = 3;
			$radB = 1;

			$target->setImageColorspace( imagick::COLORSPACE_RGB );
			$out = clone $target;
			$high = clone $target;
			$low = clone $target;

			
			$high->medianFilterImage( $radA );
			$high->blurImage( 0, $radA );
			$low->edgeImage(1);
			$low->medianFilterImage( $radB );

			$out->setImageOpacity(0.5);
			$high->setImageOpacity(0.25);
			$low->setImageOpacity(0.25);

			$out->compositeImage( $high, imagick::COMPOSITE_BLEND,0,0 );
			$out->compositeImage( $low, imagick::COMPOSITE_BLEND,0,0 );
			return $out;
		}
	}

	MajikBox::add( 'enrich', new Majik_enrich() );
?>
