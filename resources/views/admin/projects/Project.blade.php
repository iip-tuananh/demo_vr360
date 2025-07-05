@include('admin.projects.ProjectGallery')
<script>
    class Project extends BaseClass {
        all_categories = @json(\App\Model\Admin\ProjectCategory::getForSelect());
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

        get galleries() {
            return this._galleries || [];
        }

        set galleries(value) {
            this._galleries = (value || []).map(val => new ProjectGallery(val, this));
        }

        addGallery(gallery) {
            if (!this._galleries) this._galleries = [];
            let new_gallery = new ProjectGallery(gallery, this);
            this._galleries.push(new_gallery);
            return new_gallery;
        }

        removeGallery(index) {
            this._galleries.splice(index, 1);
        }


        get submit_data() {
            let data = {
                title: this.title,
                des: this.des,
                short_des: this.short_des,
                category_id: this.category_id,
                show_home_page: this.show_home_page,
            }

            data = jsonToFormData(data);
            let image = $(`#${this.image.element_id}`).get(0).files[0];
            if (image) data.append('image', image);

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
