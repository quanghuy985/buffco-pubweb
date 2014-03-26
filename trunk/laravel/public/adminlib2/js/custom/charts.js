/*
 * 	Additional function for reports.html
 *	Written by ThemePixels	
 *	http://themepixels.com/
 *	
 *	Built for Amanda Premium Responsive Admin Template
 *  http://themeforest.net/category/site-templates/admin-templates
 */

jQuery(document).ready(function(){		
		
		
	
		
		
		
		/**PIE CHART IN MAIN PAGE WHERE LABELS ARE INSIDE THE PIE CHART**/
		var data = [];
		var series = 5;
		for( var i = 0; i<series; i++) {
			data[i] = { label: "Series"+(i+1), data: Math.floor(Math.random()*100)+1 }
		}
		jQuery.plot(jQuery("#piechart"), data, {
				colors: ['#b9d6fd','#fdb5b5','#c9fdb5','#f9b5fd','#d7b5fd'],		   
				series: {
					pie: { show: true }
				}
		});
		
		
		/**ANOTHER PIE CHART IN MAIN PAGE WHERE LABELS ARER OUTSIDE THE PIE**/
		/*
		var data = [];
		var series = 5;
		for( var i = 0; i<series; i++) {
			data[i] = { label: "Series"+(i+1), data: Math.floor(Math.random()*100)+1 }
		}
		jQuery.plot(jQuery("#piechart2"), data, {
				colors: ['#ff7e00','#8aff00','#0096ff','#8400ff','#ff003c'],		   
				series: {
					pie: { show: true, radius: 1, label: { show: true, radius: 2/3, formatter: function(label, series){
                        return '<div class="pie">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
                    },
					threshold: 0.1,
                    background: { opacity: 0 }} }
				},
				legend: { show: false }
		});
		
		var data = [];
		var series = 5;
		for( var i = 0; i<series; i++) {
			data[i] = { label: "Series"+(i+1), data: Math.floor(Math.random()*100)+1 }
		}
		jQuery.plot(jQuery("#piechart3"), data, {
				colors: ['#c55c23','#8ac523','#2354c5','#8e23c5','#c52351'],		   
				series: {
					pie: { show: true }
				},
				legend: { show: false }
		});
		*/
		
		/***REAL TIME CHART***/
		// we use an inline data source in the example, usually data would
		// be fetched from a server
		var data = [], totalPoints = 300;
		function getRandomData() {
			if (data.length > 0)
				data = data.slice(1);
	
			// do a random walk
			while (data.length < totalPoints) {
				var prev = data.length > 0 ? data[data.length - 1] : 50;
				var y = prev + Math.random() * 10 - 5;
				if (y < 0)
					y = 0;
				if (y > 100)
					y = 100;
				data.push(y);
			}
	
			// zip the generated y values with the x values
			var res = [];
			for (var i = 0; i < data.length; ++i)
				res.push([i, data[i]])
			return res;
		}
	
		// setup control widget
		var updateInterval = 1000;
		jQuery("#updateInterval").val(updateInterval).change(function () {
			var v = jQuery(this).val();
			if (v && !isNaN(+v)) {
				updateInterval = +v;
				if (updateInterval < 1)
					updateInterval = 1;
				if (updateInterval > 2000)
					updateInterval = 2000;
				jQuery(this).val("" + updateInterval);
			}
		});
	
		// setup plot
		var options = {
			colors: ["#ffdd00"],
			series: { lines: { fill: true, fillColor: { colors: [ { opacity: 0.1 }, { opacity: 0.5 } ] } }, shadowSize: 0, }, // drawing is faster without shadows
			yaxis: { min: 0, max: 100 },
			grid: { borderColor: '#ccc', borderWidth: 1},
			
		};
		var plot = jQuery.plot(jQuery("#realtime"), [ getRandomData() ], options);
	
		function update() {
			plot.setData([ getRandomData() ]);
			// since the axes don't change, we don't need to call plot.setupGrid()
			plot.draw();
			
			setTimeout(update, updateInterval);
		}
	
		update();
	
		
		
});