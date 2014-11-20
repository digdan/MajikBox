<?php
	class Majik_autotone extends MajikEffect {
		function process(Imagick $target) {

			//Presets
			$target->setImageColorspace( imagick::COLORSPACE_RGB );

			$out = clone $target;
			$qr = $target->getQuantumRange();
			$min = 0;
			$mid = 1;
			$max = $qr['quantumRangeLong'];

			$mean = $target->getImageChannelMean( imagick::CHANNEL_ALL );
			$targetMean = ($min + $max) / 2;
			$diff = $targetMean / $mean['mean'];

			$out->levelImage($min,$diff,$max);

			return $out;
		}
	}

	MajikBox::add( 'autotone', new Majik_autotone() );
?>
