import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ["container"];

    static values = {
        index    : Number,
        prototype: String,
    }

    addCollectionElement(event)
    {
        const item = document.createElement('div');
        item.innerHTML = this.prototypeValue.replace(/__name__/g, this.indexValue);
        this.containerTarget.appendChild(item);
        this.indexValue++;
    }
}