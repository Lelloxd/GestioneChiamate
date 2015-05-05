function saveImages() {
   
       datapair = $sigdiv.jSignature("getData","base30") 
	// reimporting the data into jSignature.
	// import plugins understand data-url-formatted strings like "data:mime;encoding,data"
	$sigdiv.jSignature("setData", "data:" + datapair.join(",")) 
        
}