<script>
    class ServiceType extends BaseClass {
        no_set = [];

        before(form) {
        }

        after(form) {

        }

        get submit_data() {
            let data = {
                name: this.name,
                status: this.status,
            }
            data = jsonToFormData(data);

            return data;
        }
    }
</script>
