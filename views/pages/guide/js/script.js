document.querySelectorAll('[data-tabs]').forEach(function (tabs) {
    var buttons = tabs.querySelectorAll('.tab-btn');
    var panels = tabs.querySelectorAll('.tab-panel');

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var target = btn.getAttribute('data-tab');

            buttons.forEach(function (b) { b.classList.remove('active'); });
            panels.forEach(function (p) { p.classList.remove('active'); });

            btn.classList.add('active');
            var panel = tabs.querySelector('#' + target);
            if (panel) panel.classList.add('active');
        });
    });
});

document.querySelectorAll('[data-copy]').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var block = btn.closest('.code-block');
        var code = block.querySelector('pre code');
        var text = code.innerText;

        navigator.clipboard.writeText(text).then(function () {
            btn.textContent = 'Copied!';
            btn.classList.add('copied');
            setTimeout(function () {
                btn.textContent = 'Copy';
                btn.classList.remove('copied');
            }, 1500);
        }).catch(function () {
            btn.textContent = 'Failed';
            setTimeout(function () { btn.textContent = 'Copy'; }, 1500);
        });
    });
});
