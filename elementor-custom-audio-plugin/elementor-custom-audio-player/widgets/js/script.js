class WidgetAudioPlayer extends elementorModules.frontend.handlers.Base {

    getDefaultSettings() {
        return {
            selectors: {
                music: '.music',
                pButton: '.audio-play-container',
                timeline: '.audio-timeline-container',
                line: '.audio-timeline-pass',
                passtime: '.pass-time',
                alltime: '.all-time'
            },
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings('selectors');
        return {
            $music: this.$element.find(selectors.music)[0],
            $pButton: this.$element.find(selectors.pButton),
            $timeline: this.$element.find(selectors.timeline)[0],
            $line: this.$element.find(selectors.line)[0],
            $passtime: this.$element.find(selectors.passtime)[0],
            $alltime: this.$element.find(selectors.alltime)[0],
        };
    }

    bindEvents() {
        this.elements.$pButton.on('click', this.onPlayButtonClick.bind(this));
        this.elements.$music.addEventListener("timeupdate", this.timeUpdate.bind(this));
        this.elements.$music.addEventListener('loadedmetadata', (event) => {
            this.elements.$line.style.width = "0px";
            this.elements.$alltime.innerText = this._convertSeconds(event.target.duration);
        });
    }

    onPlayButtonClick(event) {
        event.preventDefault();

        if (this.elements.$music.paused) {
            this.elements.$music.play();
            this._updateIcon('played');
        } else {
            this.elements.$music.pause();
            this._updateIcon('paused');
        }

    }

    timeUpdate(event) {
        let playPercent = this.elements.$timeline.offsetWidth * (this.elements.$music.currentTime / this.elements.$music.duration);
        this.elements.$line.style.width = playPercent + "px";
        this.elements.$passtime.innerText = this._convertSeconds(this.elements.$music.currentTime);
        if (this.elements.$music.currentTime == this.elements.$music.duration) {
            this.elements.$passtime.innerText = this._convertSeconds(0);
            this.elements.$line.style.width = "0px";
            this._updateIcon('paused');
        }

    }

    _convertSeconds(second) {
        let date = new Date(null);
        date.setSeconds(second);
        return date.toISOString().substr(11, 8);
    }

    _updateIcon(state) {
        if (state == 'played') {
            this.elements.$pButton.find('.play').hide();
            this.elements.$pButton.find('.pause').show();
        } else {
            this.elements.$pButton.find('.play').show();
            this.elements.$pButton.find('.pause').hide();
        }
    }
}

jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        elementorFrontend.elementsHandler.addHandler(WidgetAudioPlayer, {
            $element,
        });
    };

    elementorFrontend.hooks.addAction('frontend/element_ready/custom_audio_player.default', addHandler);
});
