<<<<<<< HEAD
const consoleLossaccess = console;
console = {
    assert: function() {
        if(console.active && console.doAssert) {
            consoleLossaccess.assert.apply(null,arguments);
        }
    },
    clear: function() {
        if(console.active && console.doClear) {
            consoleLossaccess.clear();
        }
    },
    count: function() {
        if(console.active && console.doCount) {
            consoleLossaccess.count.apply(null,arguments);
        }
    },
    countReset: function() {
        if(console.active && console.doCountReset) {
            consoleLossaccess.countReset.apply(null,arguments);
        }
    },
    debug: function() {
        if(console.active && console.doDebug) {
            consoleLossaccess.debug.apply(null,arguments);
        }
    },
    dir: function() {
        if(console.active && console.doDir) {
            consoleLossaccess.dir.apply(null,arguments);
        }
    },
    dirxml: function() {
        if(console.active && console.doDirxml) {
            consoleLossaccess.dirxml.apply(null,arguments);
        }
    },
    error: function() {
        if(console.active && console.doError) {
            consoleLossaccess.error.apply(null,arguments);
        }
    },
    group: function() {
        if(console.active && console.doGroup) {
            consoleLossaccess.group.apply(null,arguments);
        }
    },
    groupCollapsed: function() {
        if(console.active && console.doGroup) {
            consoleLossaccess.groupCollapsed.apply(null,arguments);
        }
    },
    groupEnd: function() {
        if(console.active && console.doGroup) {
            consoleLossaccess.groupEnd.apply(null,arguments);
        }
    },
    info: function() {
        if(console.active && console.doInfo) {
            consoleLossaccess.info.apply(null,arguments);
        }
    },
    log: function() {
        if(console.active && console.doLog) {
            if(console.doLogTrace) {
                console.groupCollapsed(arguments);
                consoleLossaccess.trace.apply(null,arguments);
                console.groupEnd();
            } else {
                consoleLossaccess.log.apply(null,arguments);
            }
        }
    },
    table: function() {
        if(console.active && console.doTable) {
            consoleLossaccess.table.apply(null,arguments);
        }
    },
    time: function() {
        if(console.active && console.doTime) {
            consoleLossaccess.time.apply(null,arguments);
        }
    },
    timeEnd: function() {
        if(console.active && console.doTime) {
            consoleLossaccess.timeEnd.apply(null,arguments);
        }
    },
    timeLog: function() {
        if(console.active && console.doTime) {
            consoleLossaccess.timeLog.apply(null,arguments);
        }
    },
    trace: function() {
        if(console.active && console.doTrace) {
            consoleLossaccess.trace.apply(null,arguments);
        }
    },
    warn: function() {
        if(console.active && console.doWarn) {
            consoleLossaccess.warn.apply(null,arguments);
        }
    },
    active: false,
    doAssert: false,
    doClear: true,
    doCount: false,
    doCountReset: false,
    doDebug: false,
    doDir: false,
    doDirxml: false,
    doError: false,
    doGroup: false,
    doInfo: false,
    doLog: false,
    doLogTrace: false,
    doTable: false,
    doTime: false,
    doTrace: false,
    doWarn: false
};
=======
const consoleLossaccess = console;
console = {
    assert: function() {
        if(console.active && console.doAssert) {
            consoleLossaccess.assert.apply(null,arguments);
        }
    },
    clear: function() {
        if(console.active && console.doClear) {
            consoleLossaccess.clear();
        }
    },
    count: function() {
        if(console.active && console.doCount) {
            consoleLossaccess.count.apply(null,arguments);
        }
    },
    countReset: function() {
        if(console.active && console.doCountReset) {
            consoleLossaccess.countReset.apply(null,arguments);
        }
    },
    debug: function() {
        if(console.active && console.doDebug) {
            consoleLossaccess.debug.apply(null,arguments);
        }
    },
    dir: function() {
        if(console.active && console.doDir) {
            consoleLossaccess.dir.apply(null,arguments);
        }
    },
    dirxml: function() {
        if(console.active && console.doDirxml) {
            consoleLossaccess.dirxml.apply(null,arguments);
        }
    },
    error: function() {
        if(console.active && console.doError) {
            consoleLossaccess.error.apply(null,arguments);
        }
    },
    group: function() {
        if(console.active && console.doGroup) {
            consoleLossaccess.group.apply(null,arguments);
        }
    },
    groupCollapsed: function() {
        if(console.active && console.doGroup) {
            consoleLossaccess.groupCollapsed.apply(null,arguments);
        }
    },
    groupEnd: function() {
        if(console.active && console.doGroup) {
            consoleLossaccess.groupEnd.apply(null,arguments);
        }
    },
    info: function() {
        if(console.active && console.doInfo) {
            consoleLossaccess.info.apply(null,arguments);
        }
    },
    log: function() {
        if(console.active && console.doLog) {
            if(console.doLogTrace) {
                console.groupCollapsed(arguments);
                consoleLossaccess.trace.apply(null,arguments);
                console.groupEnd();
            } else {
                consoleLossaccess.log.apply(null,arguments);
            }
        }
    },
    table: function() {
        if(console.active && console.doTable) {
            consoleLossaccess.table.apply(null,arguments);
        }
    },
    time: function() {
        if(console.active && console.doTime) {
            consoleLossaccess.time.apply(null,arguments);
        }
    },
    timeEnd: function() {
        if(console.active && console.doTime) {
            consoleLossaccess.timeEnd.apply(null,arguments);
        }
    },
    timeLog: function() {
        if(console.active && console.doTime) {
            consoleLossaccess.timeLog.apply(null,arguments);
        }
    },
    trace: function() {
        if(console.active && console.doTrace) {
            consoleLossaccess.trace.apply(null,arguments);
        }
    },
    warn: function() {
        if(console.active && console.doWarn) {
            consoleLossaccess.warn.apply(null,arguments);
        }
    },
    active: false,
    doAssert: false,
    doClear: true,
    doCount: false,
    doCountReset: false,
    doDebug: false,
    doDir: false,
    doDirxml: false,
    doError: false,
    doGroup: false,
    doInfo: false,
    doLog: false,
    doLogTrace: false,
    doTable: false,
    doTime: false,
    doTrace: false,
    doWarn: false
};
>>>>>>> b9cdf76 (initial commit)
