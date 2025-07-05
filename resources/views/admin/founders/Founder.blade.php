<script>
    class Founder extends BaseClass {
        no_set = [];

        before(form) {
            this.image = {};
        }

        after(form) {

        }

        get image() {
            return this._image;
        }

        set image(value) {
            this._image = new Image(value, this);
        }


        get submit_data() {
            let data = {
                name: this.name,
                position: this.position,
                description: this.description,
                link_facebook: this.link_facebook,
                link_instagram: this.link_instagram,
                link_website: this.link_website,
                phone: this.phone,
                email: this.email,
                zalo: this.zalo,
            }

            data = jsonToFormData(data);
            let image = $(`#${this.image.element_id}`).get(0).files[0];
            if (image) data.append('image', image);
            return data;
        }
    }
</script>