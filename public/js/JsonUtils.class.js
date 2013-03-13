/**
 * The json utils to solve the json
 * use jquery
 * @author lin bin
 */
var JsonUtils = (function(){
	// The private attr
	var _location = "", _type = "", result = null;
	
	var JsonUtils = function(){
		
	};
	
	JsonUtils.prototype.setLocation = function(location){
		_location = location;
	};
	
	JsonUtils.prototype.setType = function(type){
		_type = type;
	};
	
	JsonUtils.prototype.getResult = function(){
		return result;
	};
	
	 /**
	  * @param string url   like 'http://teacherw.sinaapp.com/js/location.json'
	  * @return array   the result set with the location
	  */
	 JsonUtils.prototype.getMessage = function(url){
		 $.getJSON(url, function(json){
		      switch (_type) {
				case 'province':
					result = json[_type];
					break;
	            // type is city or area
				default:
					result = json[_type][_location];
					break;
			}
		 });
	 };
	 
	 return JsonUtils;
})();