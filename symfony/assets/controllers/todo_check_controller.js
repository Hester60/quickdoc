import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        csrf: String,
        url: String
    }

    check(e) {
        e.preventDefault();
        this.disableCheckbox(e.target);

        fetch(this.urlValue, {
            method: 'POST',
            body: JSON.stringify({'_csrf_token': this.csrfValue}),
            headers: {
                "Content-type": "application/json",
            },
        })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    return Promise.reject(response);
                }
            })
            .then(data => {
                if (data.isDone) {
                    e.target.labels[0].classList.toggle('text-decoration-line-through');
                    e.target.checked = true;
                } else {
                    e.target.labels[0].classList.remove('text-decoration-line-through');
                    e.target.checked = false;
                }
                this.enableCheckbox(e.target);
            })
            .catch(response => {
                response.json().then((error) => {
                    alert(error.message)
                    this.enableCheckbox(e.target);
                });
            })
    }

    disableCheckbox(target) {
        target.disabled = true;
    }

    enableCheckbox(target) {
        target.disabled = false;
    }
}
