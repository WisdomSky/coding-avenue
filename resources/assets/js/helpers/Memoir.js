/**
 * Created by webdev on 6/6/2017.
 */
import Cookies from 'js-cookie';
import lodash from 'lodash';

class Memoir {


    constructor(identifier = '_global') {
        this.getIdentifier = function() { return identifier; }
    }

    recall() {
        return Cookies.getJSON(this.getIdentifier());
    }

    remember(str) {
        let memories = this.recall() || [];
        if (lodash.findIndex(memories, (o) => o.value == str) == -1) {
            memories.push({value: str});
            Cookies.set(this.getIdentifier(), memories);
        }
        return this;
    }

    obliviate(str) {
        let memories = this.recall() || [];
        memories = lodash.filter(memories, (o) => o.value != str);
        Cookies.set(this.getIdentifier(), memories);
        return this;
    }

}

export default Memoir;