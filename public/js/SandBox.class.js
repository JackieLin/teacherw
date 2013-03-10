/**
 * Provide some function to the module
 * 
 * @author linbin
 */
var SandBox = (function() {
	/**
	 * the module data
	 */
	var pubData = {};

	/**
	 * the sandbox constructor
	 * 
	 * @param {Object}
	 *            core
	 * @param {Object}
	 *            moduleName
	 */
	var SandBox = function(core, moduleName) {
		if (!moduleName) {
			core.log("the moduleName must be exists!");
		}
		this.moduleName = moduleName;
		this.container = document.getElementById(moduleName);
		this.core = core;
	};

	/**
	 * the getter and setter about public data
	 * 
	 * @param {Object}
	 *            name
	 * @param {Object}
	 *            value
	 */
	SandBox.prototype.data = function(name, value) {
		if (typeof value != "undefined") {
			pubData[name] = value;
		} else {
			return pubData[name];
		}
	};

	/**
	 * To find the document with the selector
	 * 
	 * @param {Object}
	 *            selector
	 * @param {Object}
	 *            ctx container
	 */
	SandBox.prototype.find = function(selector, ctx) {
		ctx = ctx || this.container;
		return ctx.querySelector(selector);
	};

	/**
	 * 
	 * @param {Object}
	 *            evts evts {1.actionName 2.actionFunction}
	 */
	SandBox.prototype.listen = function(evts) {
		for ( var evt in evts) {
			core.registerEvent(this.moduleName, evt, evts[evt]);
		}
	};

	/**
	 * Add class to the element
	 * 
	 * @param {Object}
	 *            elem
	 * @param {Object}
	 *            className
	 */
	SandBox.prototype.addClass = function(elem, className) {
		if (elem.classList) {
			elem.classList.add(className);
		} else {
			var clses = elem.className.split(" "), cls, length = clses.length, find = false;
			for ( var i = 0; i < length; i++) {
				cls = clses[i];
				if (cls == className) {
					find = true;
					break;
				}
			}
			if (!find) {
				elem.className += " " + className;
			}
		}
	};

	/**
	 * To exec the queue with some time
	 */
	SandBox.prototype.queue = function() {
		var funs = function() {
		}, oldfun;
		for ( var i = arguments.length - 1, obj; i >= 0; i--) {
			obj = arguments[i];
			oldfun = funs;
			// call all the function
			(function(obj, oldfun) {

				funs = function() {
					setTimeout(function() {
						obj.fn();
						oldfun();
					}, obj.time || 0);
				};

			})(obj, oldfun);
		}
		funs();
	};

	/**
	 * To remove the class
	 * 
	 * @param {Object}
	 *            elem
	 * @param {Object}
	 *            className
	 */
	SandBox.prototype.removeClass = function(elem, className) {
		if (elem.classList) {
			elem.classList.remove(className);
		} else {
			var clses = elem.className.split(" "), cls, len = clses.length;
			for ( var i = 0; i < len; i++) {
				cls = clses[i];
				if (cls == className) {
					if (i == 0) {
						if (len > 1) {
							className = className + " ";
						}
					} else {
						className = " " + className;
					}
					elem.className = elem.className.replace(className, "");
				}
			}
		}
	};

	/**
	 * notify event registered by events
	 * 
	 * @param {string}
	 *            evtObj
	 * @see Core.triggerEvent
	 */
	SandBox.prototype.notify = function(evtObj) {
		this.core.triggerEvent(evtObj);
	};

	/**
	 * execute the script
	 * 
	 * @param {Object}
	 *            script
	 */
	SandBox.prototype.eval = function(scripts) {
		eval(scripts);
	};

	/**
	 * use ajax to send data
	 * 
	 * @param {Object}
	 *            data {'type': string 'postdata': string(when post type have)
	 *            'url': string 'success': function}
	 */
	SandBox.prototype.ajax = function(data) {
		this.core.ajax(data);
	};

	/**
	 * 
	 * @param string reg      cookie regexp
	 * @return array          when the cookie result
	 */
	SandBox.prototype.getcookie = function(reg){
		if(!reg){
			this.core.log("The cookie name is not exsist");
		}
		var cookies = document.cookie, arr = cookies.split('; '), result = [], temp;
		for(var i = 0, t; t = arr[i]; i++){
			
			if(t.indexOf(reg) >= 0){
				temp = t.split('=');
				result[temp[0]] = temp[1];
			}
		}
		return result;
	};
	
	/**
	 * fill the cookie to the elements
	 * @param array cookies    cookie name
	 * @param array elems      The input elements
	 */
	SandBox.prototype.fillFrom = function(cookies, elems){
		if(!cookies || !elems){
			this.core.log("the cookies and elements should be exsist");
		}
		for(var i = 0, t; t = elems[i]; i++){
			t.value = cookies[t.name];
		}
	};
	
	return SandBox;
})();
