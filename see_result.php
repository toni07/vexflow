<!DOCTYPE html>
<html>

<head>
    <title>VexFlow Tests</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
	<script src="src/vex.js"></script>
	<script src="src/flow.js"></script>
	<script src="src/music.js"></script>
	<script src="src/stavebarline.js"></script>
	<?php
	if ($handle = opendir('./src')) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != ".." && substr($entry, -3) == '.js') {
				echo "<script src=\"src/{$entry}\"></script>\n";
			}
		}
		closedir($handle);
	}
	?>
	<script src="src/fonts/gonville.js"></script>
	<script src="src/fonts/gonville_all.js"></script>
	<script src="src/fonts/gonville_original.js"></script>
	<script src="src/fonts/vexflow_font.js"></script>
</head>
<body>
    <div>
        <canvas width="1400" height="170"></canvas>
    </div>
    <div id="toto"></div>
    <script>
        $(document).ready(function() {
            // Get the rendering context
            var canvas = $("canvas")[0];
            /*var renderer = new Vex.Flow.Renderer(canvas, Vex.Flow.Renderer.Backends.CANVAS);*/
            var renderer = new Vex.Flow.Renderer('toto', Vex.Flow.Renderer.Backends.SVG);

            var ctx = renderer.getContext();
            ctx.setFont("Arial", 10, "").setBackgroundFillStyle("#eed");

            // Create and draw the tablature stave
            var tabstave = new Vex.Flow.TabStave(10, 0, 500);
            tabstave.addTabGlyph();
            tabstave.setContext(ctx).draw();

            var functionClickOnNote = function(){
                console.log('##clicked on', this);
            };

            // Create some notes
            var notes = [
                // A single note
                new Vex.Flow.TabNote({
                    positions: [{str: 3, fret: 7, iddb: 1, clickCallBack: functionClickOnNote}],
                    duration: "q"}),

                // A chord with the note on the 3rd string bent
                new Vex.Flow.TabNote({
                    positions: [{str: 2, fret: 10, iddb: 2, clickCallBack: functionClickOnNote},
                        {str: 3, fret: 9, iddb: 1, clickCallBack: functionClickOnNote}],
                    duration: "q"}).
                        addModifier(new Vex.Flow.Bend("Full"), 1),

                // A single note with a harsh vibrato
                new Vex.Flow.TabNote({
                    positions: [{str: 2, fret: 5}],
                    duration: "h"}).
                        addModifier(new Vex.Flow.Vibrato().setHarsh(true).setVibratoWidth(70), 0)
            ];

            Vex.Flow.Formatter.FormatAndDraw(ctx, tabstave, notes);
        });
    </script>
</body>
</html>
