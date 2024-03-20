$.fn.downloadPDF = function(param) {
	var random = Math.random().toString(12).substr(2);
	$('body').append('<div id="print_pdf_3384" style="display:none !important;"></div>');	
    var doc = new jsPDF();
    try { var file = param.file; } catch(e){ var file = 'JqueryPDF_'+random; }
    try { var width = param.width; } catch(e){ var width = 170; }
	var handlers = {
	    '#print_pdf_3384': function (element, renderer) {
	        return true;
	    }
	};
	doc.fromHTML(this.html(), 15, 15, {
        'width':width,
            'elementHandlers': handlers
    });
    doc.save(file+'.pdf');
};