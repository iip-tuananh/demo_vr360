@include('admin.configs.ConfigGallery')
@include('admin.configs.ZaloChat')
<script>
    class Config extends BaseClass {
        no_set = [];
        before(form) {
            this.image = {};
            this.introduction_image = {};
        }
        after(form) {
        }
        get image() {
            return this._image;
        }
        set image(value) {
            this._image = new Image(value, this);
        }
		clearImage() {
			if (this.image) this.image.clear();
		}

        get introduction_image() {
            return this._introduction_image;
        }
        set introduction_image(value) {
            this._introduction_image = new Image(value, this);
        }
		clearIntroductionImage() {
			if (this.introduction_image) this.introduction_image.clear();
		}

        // get zalo_chat() {
        //     return this._zalo_chat;
        // }

        // set zalo_chat(value) {
        //     if (value) {
        //         this._zalo_chat = (value || []).map(val => new ZaloChat(val, this));
        //     } else {
        //         this._zalo_chat = [new ZaloChat({}, this)];
        //     }
        // }

        // addZaloChat() {
        //     this._zalo_chat.push(new ZaloChat({}, this));
        // }

        // removeZaloChat(index) {
        //     this._zalo_chat.splice(index, 1);
        // }

        get favicon() {
            return this._favicon;
        }

        set favicon(value) {
            this._favicon= new Image(value, this);
        }

        clearFavicon() {
            if (this.favicon) this.favicon.clear();
        }

        get galleries() {
            return this._galleries || [];
        }

        set galleries(value) {
            this._galleries = (value || []).map(val => new ConfigGallery(val, this));
        }

        addGallery(gallery) {
            if (!this._galleries) this._galleries = [];
            let new_gallery = new ConfigGallery(gallery, this);
            this._galleries.push(new_gallery);
            return new_gallery;
        }

        removeGallery(index) {
            this._galleries.splice(index, 1);
        }

        get submit_data() {
            let data = {
                web_title: this.web_title,
                meta_title: this.meta_title,
                web_des: this.web_des,
                short_name_company: this.short_name_company,
                email: this.email,
                twitter: this.twitter,
                instagram: this.instagram,
                youtube: this.youtube,
                facebook: this.facebook,
                hotline: this.hotline,
                address_company: this.address_company,
                address_center_insurance: this.address_center_insurance,
                zalo: this.zalo,
                location: this.location,
                click_call: this.click_call,
                facebook_chat: this.facebook_chat,
                // zalo_chat: JSON.stringify(this._zalo_chat.map(z => z.submit_data)),
                phone_switchboard: this.phone_switchboard,
                introduction: this.introduction,
                tax_code: this.tax_code,
            }
            data = jsonToFormData(data);
            let image = this.image.submit_data;
            if (image) data.append('image', image);
            let favicon = this.favicon.submit_data;
            if (favicon) data.append('favicon', favicon);
            let introduction_image = this.introduction_image.submit_data;
            if (introduction_image) data.append('introduction_image', introduction_image);

            this.galleries.forEach((g, i) => {
                if (g.id) data.append(`galleries[${i}][id]`, g.id);
                let gallery = g.image.submit_data;
                if (gallery) data.append(`galleries[${i}][image]`, gallery);
                else data.append(`galleries[${i}][image_obj]`, g.id);
            })

            return data;
        }
    }
</script>
