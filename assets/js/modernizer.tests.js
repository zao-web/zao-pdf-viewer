function Promise() {
}
Promise.prototype = {
    then: function (callback) {
        this.callback = callback;
        if ('result' in this) callback(this.result);
    },
    resolve: function (result) {
        if ('result' in this) return;
        this.result = result;
        if ('callback' in this) this.callback(result);
    }
};

Modernizr.addTest('getLiteral', function () {
    try {
        var Test = eval('var Test =  { get t() { return {}; } }; Test');
        Test.t.test = true;
        return true;
    } catch (e) {
        return false;
    }
});
Modernizr.addTest('addEventListener', function () {
    var div = document.createElement('div');
    if (div.addEventListener)
        return true;
    else
        return false;
});
Modernizr.addTest('Uint8Array', function () {
    if (typeof Uint8Array !== 'undefined')
        return true;
    else
        return 'emulated';
});
Modernizr.addTest('Uint16Array', function () {
    if (typeof Uint16Array !== 'undefined')
        return true;
    else
        return 'emulated';
});
Modernizr.addTest('Int32Array', function () {
    if (typeof Int32Array !== 'undefined')
        return true;
    else
        return 'emulated';
});
Modernizr.addTest('Float32Array', function () {
    if (typeof Float32Array !== 'undefined')
        return true;
    else
        return 'emulated';
});
Modernizr.addTest('Float64Array', function () {
    if (typeof Float64Array !== 'undefined')
        return true;
    else
        return 'emulated';
});
Modernizr.addTest('ObjectCreate', function () {
    if (Object.create instanceof Function)
        return true;
    else
        return 'emulated';
});
Modernizr.addTest('ObjectDefineProperty', function () {
    if (Object.defineProperty instanceof Function)
        return true;
    else
        return 'emulated';
});
Modernizr.addTest('ObjectDefinePropertyDOM', function () {
    if (!(Object.defineProperty instanceof Function))
        return 'skipped';
    try {
        // some browsers (e.g. safari) cannot use defineProperty() on DOM objects
        // and thus the native version is not sufficient
        Object.defineProperty(new Image(), 'id', { value: 'test' });
        return true;
    } catch (e) {
        return 'emulated';
    }
});
Modernizr.addTest('getLiteralRedefine', function () {
    if (!(Object.defineProperty instanceof Function))
        return 'skipped';
    try {
        var TestGetter = eval('var Test = function () {}; Test.prototype = { get id() { } }; Test');
        Object.defineProperty(new TestGetter(), 'id',
            { value: '', configurable: true, enumerable: true, writable: false });
        return true;
    } catch (e) {
        return 'emulated';
    }
});
Modernizr.addTest('ObjectKeys', function () {
    if (Object.keys instanceof Function)
        return true;
    else
        return 'emulated';
});

Modernizr.addTest('FileReader', function () {
    if (typeof FileReader !== 'undefined')
        return true;
    else
        return false;
});
Modernizr.addTest('FileReaderReadAsArrayBuffer', function () {
    if (typeof FileReader === 'undefined')
        return 'skipped';
    if (FileReader.prototype.readAsArrayBuffer instanceof Function)
        return true;
    else
        return 'emulated';
});
Modernizr.addTest('XMLHttpRequestOverrideMimeType', function () {
    if (XMLHttpRequest.prototype.overrideMimeType instanceof Function)
        return true;
    else
        return 'emulated';
});
Modernizr.addTest('XMLHttpRequestResponse', function () {
    var xhr = new XMLHttpRequest();
    if ('response' in xhr)
        return true;
    else
        return 'emulated';
});
Modernizr.addTest('bota', function () {
    if ('btoa' in window)
        return true;
    else
        return 'emulated';
});
Modernizr.addTest('atob', function () {
    if ('atob' in window)
        return true;
    else
        return 'emulated';
});
Modernizr.addTest('FunctionBind', function () {
    if (Function.prototype.bind instanceof Function)
        return true;
    else
        return 'emulated';
});
Modernizr.addTest('dataset', function () {
    var div = document.createElement('div');
    if ('dataset' in div)
        return true;
    else
        return 'emulated';
});
Modernizr.addTest('classList', function () {
    var div = document.createElement('div');
    if ('classList' in div)
        return true;
    else
        return 'emulated';
});
Modernizr.addTest('console', function () {
    if ('console' in window)
        return true;
    else
        return 'emulated';
});
Modernizr.addTest('consoleLogBind', function () {
    if (!('console' in window))
        return 'skipped';
    if ('bind' in console.log)
        return true;
    else
        return 'emulated';
});
Modernizr.addTest('navigatorLanguage', function () {
    if ('language' in navigator)
        return true;
    else
        return 'emulated';
});
Modernizr.addTest('fillRuleEvenodd', function () {
    if (!Modernizr.canvas)
        return 'skipped';

    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d');
    ctx.rect(1, 1, 50, 50);
    ctx.rect(5, 5, 41, 41);

    if ('mozFillRule' in ctx) {
        ctx.mozFillRule = 'evenodd';
        ctx.fill();
    } else {
        ctx.fill('evenodd');
    }

    var data = ctx.getImageData(0, 0, 50, 50).data;
    var isEvenOddFill = data[20 * 4 + 20 * 200 + 3] == 0 &&
        data[2 * 4 + 2 * 200 + 3] != 0;

    if (isEvenOddFill)
        return true;
    else
        return false;
});
Modernizr.addTest('dashArray', function () {
    if (!Modernizr.canvas)
        return 'skipped';

    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d');
    ctx.moveTo(0, 5);
    ctx.lineTo(50, 5);
    ctx.lineWidth = 10;

    if ('setLineDash' in ctx) {
        ctx.setLineDash([10, 10]);
        ctx.lineDashOffset = 0;
    } else {
        ctx.mozDash = [10, 10];
        ctx.mozDashOffset = 0;
    }
    ctx.stroke();

    var data = ctx.getImageData(0, 0, 50, 50).data;
    var isDashed = data[5 * 4 + 5 * 200 + 3] != 0 &&
        data[15 * 4 + 5 * 200 + 3] == 0;

    if (isDashed)
        return true;
    else
        return false;
});
Modernizr.addTest('fontFace', function () {
    if (!Modernizr.canvas)
        return 'skipped';
    var promise = new Promise();
    setTimeout(function () {
        if (checkCanvas('plus'))
            promise.resolve(true);
        else
            promise.resolve(false);
    }, 2000);
    return promise;
});
Modernizr.addTest('fontFaceSync', function () {
    if (!Modernizr.canvas)
        return 'skipped';

    // Add the font-face rule to the document
    var rule = '@font-face { font-family: \'plus-loaded\'; src: url(data:font/opentype;base64,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); }';

    var styleElement = document.getElementById('font-faces');
    var styleSheet = styleElement.sheet;
    styleSheet.insertRule(rule, styleSheet.cssRules.length);

    // checking if data urls are loaded synchronously
    if (checkCanvas('plus-loaded'))
        return true;

    // TODO checking if data urls are loaded asynchronously

    var usageElement = document.createElement('div');
    usageElement.setAttribute('style', 'font-family: plus-loaded; visibility: hidden;');
    usageElement.textContent = '`';
    document.body.appendChild(usageElement);

    // verify is font is loaded
    var promise = new Promise();
    setTimeout(function () {
        if (checkCanvas('plus-loaded'))
            promise.resolve({ output: 'Failed', emulated: 'Yes' });
        else
            promise.resolve(false);
    }, 2000);
    return promise;
});
Modernizr.addTest('Worker', function () {
    if (typeof Worker != 'undefined')
        return true;
    else
        return false;
});
Modernizr.addTest('WorkerUint8Array', function () {
    if (typeof Worker == 'undefined')
        return 'skipped';

    try {
        var worker = new Worker('worker-stub.min.js');

        var promise = new Promise();
        var timeout = setTimeout(function () {
            promise.resolve({ output: 'Failed', emulated: '?' });
        }, 5000);

        worker.addEventListener('message', function (e) {
            var data = e.data;
            if (data.action == 'test' && data.result)
                promise.resolve(true);
            else
                promise.resolve({ output: 'Failed', emulated: 'Yes' });
        }, false);
        worker.postMessage({action: 'test',
            data: new Uint8Array(60000000)}); // 60MB
        return promise;
    } catch (e) {
        return 'emulated';
    }
});
Modernizr.addTest('WorkerTransfers', function () {
    if (typeof Worker == 'undefined')
        return 'skipped';

    try {
        var worker = new Worker('worker-stub.min.js');

        var promise = new Promise();
        var timeout = setTimeout(function () {
            promise.resolve({ output: 'Failed', emulated: '?' });
        }, 5000);

        worker.addEventListener('message', function (e) {
            var data = e.data;
            if (data.action == 'test-transfers' && data.result)
                promise.resolve(true);
            else
                promise.resolve({ output: 'Failed', emulated: 'Yes' });
        }, false);
        var testObj = new Uint8Array([255]);
        worker.postMessage({action: 'test-transfers',
            data: testObj}, [testObj.buffer]);
        return promise;
    } catch (e) {
        return 'emulated';
    }
});
Modernizr.addTest('WorkerXhrResponse', function () {
    if (typeof Worker == 'undefined')
        return 'skipped';

    try {
        var worker = new Worker('worker-stub.min.js');

        var promise = new Promise();
        var timeout = setTimeout(function () {
            promise.resolve({ output: 'Failed', emulated: '?' });
        }, 5000);

        worker.addEventListener('message', function (e) {
            var data = e.data;
            if (data.action == 'xhr' && data.result)
                promise.resolve(true);
            else
                promise.resolve({ output: 'Failed', emulated: 'Yes' });
        }, false);
        worker.postMessage({action: 'xhr'});
        return promise;
    } catch (e) {
        return 'emulated';
    }
});
Modernizr.addTest('CanvasBlendMode', function () {
    var fail = false;
    var ctx = document.createElement('canvas').getContext('2d');
    ctx.canvas.width = 1;
    ctx.canvas.height = 1;
    var mode = 'difference';
    ctx.globalCompositeOperation = mode;
    if (ctx.globalCompositeOperation !== mode) {
        return fail;
    }
    // Chrome supports setting the value, but it may not actually be
    // implemented, so we have to actually test the blend mode.
    ctx.fillStyle = 'red';
    ctx.fillRect(0, 0, 1, 1);
    ctx.fillStyle = 'blue';
    ctx.fillRect(0, 0, 1, 1);
    var pix = ctx.getImageData(0, 0, 1, 1).data;
    if (pix[0] !== 255 || pix[1] !== 0 || pix[2] !== 255) {
        return fail;
    }
    return true;
});

function checkCanvas(font) {
    var canvas = document.createElement('canvas');
    var canvasHolder = document.getElementById('canvasHolder');
    canvasHolder.appendChild(canvas);
    var ctx = canvas.getContext('2d');
    ctx.font = '40px \'' + font + '\'';
    ctx.fillText('\u0060', 0, 40);
    var data = ctx.getImageData(0, 0, 40, 40).data;
    canvasHolder.removeChild(canvas);

    // detects plus figure
    var minx = 40, maxx = 0, miny = 40, maxy = 0;
    for (var y = 0; y < 40; y++) {
        for (var x = 0; x < 40; x++) {
            if (data[x * 4 + y * 160 + 3] == 0) continue; // no color
            minx = Math.min(minx, x);
            miny = Math.min(miny, y);
            maxx = Math.max(maxx, x);
            maxy = Math.max(maxy, y);
        }
    }

    var colors = [
        [0, 0, 0],
        [0, 0, 0],
        [0, 0, 0]
    ];
    var counts = [
        [0, 0, 0],
        [0, 0, 0],
        [0, 0, 0]
    ];
    for (var y = miny; y <= maxy; y++) {
        for (var x = minx; x <= maxx; x++) {
            var i = Math.floor((x - minx) * 3 / (maxx - minx + 1));
            var j = Math.floor((y - miny) * 3 / (maxy - miny + 1));
            counts[i][j]++;
            if (data[x * 4 + y * 160 + 3] != 0)
                colors[i][j]++;
        }
    }
    var isPlus =
        colors[0][0] * 3 < counts[0][0] &&
        colors[0][1] * 3 > counts[0][1] &&
        colors[0][2] * 3 < counts[0][2] &&
        colors[1][0] * 3 > counts[1][0] &&
        colors[1][1] * 3 > counts[1][1] &&
        colors[1][2] * 3 > counts[1][2] &&
        colors[2][0] * 3 < counts[2][0] &&
        colors[2][1] * 3 > counts[2][1] &&
        colors[2][2] * 3 < counts[2][2];
    return isPlus;
}
var pdfv = {};
pdfv.tests = [
'canvas',
'getLiteral',
'addEventListener',
'Uint8Array',
'Uint16Array',
'Int32Array',
'Float32Array',
'Float64Array',
'ObjectCreate',
'ObjectDefineProperty',
'ObjectDefinePropertyDOM',
'getLiteralRedefine',
'ObjectKeys',
'FileReader',
'FileReaderReadAsArrayBuffer',
'XMLHttpRequestOverrideMimeType',
'XMLHttpRequestResponse',
'bota',
'atob',
'FunctionBind',
'dataset',
'classList',
'console',
'consoleLogBind',
'navigatorLanguage',
'fillRuleEvenodd',
'dashArray',
'fontFace',
'fontFaceSync',
'Worker',
'WorkerUint8Array',
'WorkerTransfers',
'WorkerXhrResponse',
'CanvasBlendMode'
];