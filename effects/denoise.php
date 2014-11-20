<?php
	class Majik_denoise extends MajikEffect {
		function process(Imagick $target) {
			$a = clone $target;
			$b = clone $target;
			$out = clone $target;
			
			$a->medianFilterImage( 5 );	
			$a->edgeImage(1);
			$b->blurImage( 0,5 );	

                        $out->setImageOpacity(0.4);
                        $a->setImageOpacity(0.2);
                        $b->setImageOpacity(0.6);

                        $out->compositeImage( $b, imagick::COMPOSITE_BLEND,0,0 );
                        $out->compositeImage( $a, imagick::COMPOSITE_BLEND,0,0 );
			
			return $out;
		}
	}

	MajikBox::add( 'denoise', new Majik_denoise() );
?>
