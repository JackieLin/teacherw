/**
 * @author linbin
 * The core module to the project
 */
var Core = (function() {
	// private objects
	var modules = {}, events = {};

	return {
		/**
		 * To resgister the module
		 * @param  moduleName
		 * @param  creator
		 */
		registerModule : function(moduleName, creator) {
            if(!moduleName || !creator){
            	this.log("the moduleName and creator should not be null");
            	return;
            }
            if(modules[moduleName]){
            	this.log("the module " + moduleName + "is exist!");
                return;
            }
            // register the module
            module = modules[moduleName] = {
            	creator : creator,
                // static instance factory,instance once
            	instance : null,
            	sandBox : new SandBox(this,moduleName),
            	events : []
            };
		},

        /**
         * @param {Object} evtObj
         *        evtObj {{string}type, {object} data}
         *               type: event name
         *               data: the params should be done
         */
        triggerEvent : function (evtObj){
        	 var type = evtObj.type , data = evtObj.data;
        	 if(!type){
        	 	this.log("Core.triggerEvent: the type is lost");
        	    return;
        	 }
        	 var fns = events[type];
        	 if(!fns){
        	 	 return;
        	 }
        	 for(var i = 0, fn; fn = fns[i];i++){
        	 	fn(data);
        	 }
        },
        
        /**
         *  To start the module
         *  @param {string} moduleName
         *  @param {object} varArgs
         */
        start : function (moduleName,varArgs){
        	var module = modules[moduleName];
        	if(!module){
        		this.log("the module " + moduleName + "is not exist");
        	    return;
        	}
        	if(module.instance){
        		return;
        	}
            var args = [];
            args.push(module.sandBox);
            for(var i = 1,arg; arg = arguments[i];i++){
            	args.push(arg);
            }
            // instance the module
            module.instance = module.creator.apply(this,args);
            // call the module init
            module.instance.init();
        },
        
        /**
         *  To start all modules
         */
        startAll : function (extraElems) {
        	for(var moduleName in modules){
        		var module = modules[moduleName];
        		if(module && module.instance){
        			continue;
        		}
        		var args = [],
        		    extra = extraElems ? extraElems[moduleName] : undefined;
        		
        		args.push(moduleName);
        		if(extra){
        			for(var i = 0,t; t = extra[i];i++){
        				args.push(t);
        			}
        		}
        		// call the start function
        		this.start.apply(this,args);
        	}
        },
        
        /**
         *  @param moduleName {string}
         *  @param evt {string} event name
         *  @param fn {function} the event function
         */
        registerEvent : function (moduleName,evt,fn){
        	var module = modules[moduleName];
        	if(!module && moduleName){
        		this.log("the module is not exist");
        	    return;
        	}
        	if(typeof fn !== "function"){
        		this.log("the event must be a function");
        		return;
        	}
        	var oldFun = module.events[evt];
        	if(oldFun){
        	    // unregister the event	
        	    this.unregisterEvent(moduleName,evt);
        	}
        	module.events[evt] = fn;
            var fns = events[evt];
        	if(!fns){
        		fns = [];
        		events[evt] = fns;
        	}
        	fns.push(events);
        },
        
        /**
         * @param moduleName {string}
         * @param evt {string} event namr
         */
        unregisterEvent : function (moduleName, evt){
        	var module = modules[moduleName];
        	if(!module || !module.instance){
        		this.log("the module" + moduleName + "is not exist");
        		return;
        	}
        	var fn = module.events[evt], fns = events[evt];
        	
        	if(fn && fns){
        		for(var i = 0,tmpEvt; tmpEvt = fns[i];i++){
        			if(tmpEvt == fn){
        				fns.splice(i,1);
        				break;
        			}
        		}
        		if(fns.length == 0){
        			delete events[evt];
        		}
        	}
        	delete module.events[evt];
        },
        
		/**
		 *  To alert the message
		 * @param {Object} message
		 */
		log : function(message) {
            alert("log= " + message);
		}
	}
})();
