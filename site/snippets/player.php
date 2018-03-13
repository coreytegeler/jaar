<div id="player">
	<div class="audiojs">
		<audio preload></audio>
			<div class="play-pause">
				<div class="ghosts">
					<svg class="icon icon-backward"><use xlink:href="#icon-backward"></use></svg>
					<svg class="icon icon-play"><use xlink:href="#icon-play"></use></svg>
					<svg class="icon icon-forward"><use xlink:href="#icon-forward"></use></svg>
				</div>
				<button class="prev">
					 <svg class="icon icon-backward"><use xlink:href="#icon-backward"></use></svg>
				</button>
				<button class="play">
					<svg class="icon icon-play"><use xlink:href="#icon-play"></use></svg>
				</button>
				<button class="pause">
					 <svg class="icon icon-pause"><use xlink:href="#icon-pause"></use></svg>
				</button>
				<button class="next">
					<svg class="icon icon-forward"><use xlink:href="#icon-forward"></use></svg>
				</button>
			</div>
			<div class="track-name">No Track</div>
			<div class="scrubber">
				<div class="progress"></div>
				<div class="loaded"></div>
				 <div class="time">
					<span class="duration">00:00</span>/<span class="played">00:00</span>
				</div>
			</div>
			<div class="error-message"></div>
	</div>
</div>

<svg style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
  <defs>
    <symbol id="icon-play" viewBox="0 0 32 32">
      <title>play</title><path class="path1" d="M6 4l20 12-20 12z"></path>
    </symbol>
    <symbol id="icon-pause" viewBox="0 0 32 32">
      <title>pause</title><path class="path1" d="M4 4h10v24h-10zM18 4h10v24h-10z"></path>
    </symbol>
    <symbol id="icon-backward" viewBox="0 0 32 32">
      <title>backward</title><path class="path1" d="M18 5v10l10-10v22l-10-10v10l-11-11z"></path>
    </symbol>
    <symbol id="icon-forward" viewBox="0 0 32 32">
      <title>forward</title><path class="path1" d="M16 27v-10l-10 10v-22l10 10v-10l11 11z"></path>
    </symbol>
  </defs>
</svg>