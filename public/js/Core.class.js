/**
 * @author linbin The core module to the project
 */
var Core = (function() {
	// private objects
	var modules = {}, events = {};

	return {
		/**
		 * To resgister the module
		 * 
		 * @param moduleName
		 * @param creator
		 */
		registerModule : function(moduleName, creator) {
			if (!moduleName || !creator) {
				this.log("the moduleName and creator should not be null");
				return;
			}
			if (modules[moduleName]) {
				this.log("the module " + moduleName + "is exist!");
				return;
			}
			// register the module
			module = modules[moduleName] = {
				creator : creator,
				// static instance factory,instance once
				instance : null,
				sandBox : new SandBox(this, moduleName),
				events : []
			};
		},

		/**
		 * @param {Object}
		 *            evtObj evtObj {{string}type, {object} data} type: event
		 *            name data: the params should be done
		 */
		triggerEvent : function(evtObj) {
			var type = evtObj.type, data = evtObj.data;
			if (!type) {
				this.log("Core.triggerEvent: the type is lost");
				return;
			}
			var fns = events[type];
			if (!fns) {
				return;
			}
			for ( var i = 0, fn; fn = fns[i]; i++) {
				fn(data);
			}
		},

		/**
		 * To start the module
		 * 
		 * @param {string}
		 *            moduleName
		 * @param {object}
		 *            varArgs
		 */
		start : function(moduleName, varArgs) {
			var module = modules[moduleName];
			if (!module) {
				this.log("the module " + moduleName + "is not exist");
				return;
			}
			if (module.instance) {
				return;
			}
			var args = [];
			args.push(module.sandBox);
			for ( var i = 1, arg; arg = arguments[i]; i++) {
				args.push(arg);
			}
			// instance the module
			module.instance = module.creator.apply(this, args);
			// call the module init
			module.instance.init();
		},

		/**
		 * To start all modules
		 */
		startAll : function(extraElems) {
			for ( var moduleName in modules) {
				var module = modules[moduleName];
				if (module && module.instance) {
					continue;
				}
				var args = [], extra = extraElems ? extraElems[moduleName]
						: undefined;

				args.push(moduleName);
				if (extra) {
					for ( var i = 0, t; t = extra[i]; i++) {
						args.push(t);
					}
				}
				// call the start function
				this.start.apply(this, args);
			}
		},

		/**
		 * @param moduleName
		 *            {string}
		 * @param evt
		 *            {string} event name
		 * @param fn
		 *            {function} the event function
		 */
		registerEvent : function(moduleName, evt, fn) {
			var module = modules[moduleName];
			if (!module && moduleName) {
				this.log("the module is not exist");
				return;
			}
			if (typeof fn !== "function") {
				this.log("the event must be a function");
				return;
			}
			var oldFun = module.events[evt];
			if (oldFun) {
				// unregister the event
				this.unregisterEvent(moduleName, evt);
			}
			module.events[evt] = fn;
			var fns = events[evt];
			if (!fns) {
				fns = [];
				events[evt] = fns;
			}
			fns.push(events);
		},

		/**
		 * @param moduleName
		 *            {string}
		 * @param evt
		 *            {string} event namr
		 */
		unregisterEvent : function(moduleName, evt) {
			var module = modules[moduleName];
			if (!module || !module.instance) {
				this.log("the module" + moduleName + "is not exist");
				return;
			}
			var fn = module.events[evt], fns = events[evt];

			if (fn && fns) {
				for ( var i = 0, tmpEvt; tmpEvt = fns[i]; i++) {
					if (tmpEvt == fn) {
						fns.splice(i, 1);
						break;
					}
				}
				if (fns.length == 0) {
					delete events[evt];
				}
			}
			delete module.events[evt];
		},

		/**
		 * data: object {'type': string 'postdata': string(when post type have)
		 * 'url': string 'success': function}
		 */
		ajax : function(data) {
			var type = data['type'], postdata = data['postdata'], url = data['url'], successFun = data['success'], xmlHttp
			, async = arguments[1];

			if (!data || !type || !url || !successFun) {
				this
						.log("The data param should be exites or should be complete!");
			}

			if (typeof successFun !== 'function') {
				this.log("the success param should be function!");
			}

			// create xmlHttp instance
			if (window.XMLHttpRequest) {
				xmlHttp = new XMLHttpRequest();
			} else {
				xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			}

			// receieve data
			xmlHttp.onreadystatechange = function(){
				// success
				if (xmlHttp.readyState==4 && xmlHttp.status==200){
					// call the success function
					successFun.call(this, xmlHttp.responseText);
				}	
			};
			// 设置同步或异步
			if(async === false){
				xmlHttp.open(type, url, async); 
			} else{
				xmlHttp.open(type, url, true);	
			}
			if (postdata) {
				xmlHttp.setRequestHeader("Content-type",
						"application/x-www-form-urlencoded");
				xmlHttp.send(postdata);
			} else {
				xmlHttp.send();
			}
		},
		
		/**
		 * To return the location by url
		 * @param url            The json path
		 * @param datas          eg: {location:'', type: ''}
		 * @returns array
		 */
		getLocation: function(url, datas){
			if(!url || !datas){
				this.log("The url and datas must be exsist!!");
			}
			var type = datas.type, location = datas.location, result = null;
			// To get json
		    this.ajax({
		    	'type': 'GET',
		    	'url': url,
		    	'success': function(data){
		    		// 转换为对象
		    		obj = JSON.parse(data);
		    		switch (type) {
					case 'province':
						result = obj[type];
						break;

					default:
						result = obj[type][location]
						break;
					}
		    	}
		    }, false);
		    return result;
		},
		
		/**
		 * To alert the message
		 * 
		 * @param {Object}
		 *            message
		 */
		log : function(message) {
			alert("log= " + message);
		}
	};
})();
