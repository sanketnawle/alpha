function EventTarget() {
    this.__listeners = {};
}
Object.defineProperties(EventTarget.prototype, {
    addListener: {
        value: function (type, listener) {            
            if (type == undefined) return;
            else if (listener == undefined || typeof listener != "function") return;
            else if (this.__listeners[type] == undefined) this.__listeners[type] = [];
            this.__listeners[type].push(listener);
        }
    },
    removeListener: {
        value: function (type, listener) {
            if (type == undefined) this.__listeners = {};
            else {
                if (!listener) delete this.__listeners[type];
                else {
                    var listeners = this.__listeners[type];
                    if (!listeners) return;
                    for (var i = 0, len = listeners.length; i < len; ++i)
                        if (listeners[i] === listener) {
                            listeners.splice(i, 1);
                            return;
                        }
                }
            }
        }
    },
    __fire: {
        value: function (e) {
            if (e == undefined) return;
            else if (typeof e != "object") e = { type: e };
            else if (e.type == undefined) return;

            if (!e.target) e.target = this;

            var listeners = e.target.__listeners[e.type];
            
            if (!listeners) return;
            for (var i = 0, len = listeners.length; i < len; ++i) {
                listeners[i].call(e.target, e);
            }            
        }
    }
});