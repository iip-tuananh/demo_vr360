<style>
    .gallery-item {
        padding: 5px;
        padding-bottom: 0;
        border-radius: 2px;
        border: 1px solid #bbb;
        min-height: 100px;
        height: 100%;
        position: relative;
    }

    .gallery-item .remove {
        position: absolute;
        top: 5px;
        right: 5px;
    }

    .gallery-item .drag-handle {
        position: absolute;
        top: 5px;
        left: 5px;
        cursor: move;
    }

    .gallery-item:hover {
        background-color: #eee;
    }

    .gallery-item .image-chooser img {
        max-height: 150px;
    }

    .gallery-item .image-chooser:hover {
        border: 1px dashed green;
    }
</style>
<div class="row">
    <div class="col-md-9 col-sm-8 col-xs-12">
        <div class="card-block">
            <div class="tab-content tab-custom">
                <div class="tab-pane p-0 active" id="vi">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Thông tin chung</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group custom-group mb-4">
                                                <label class="form-label required-label">Danh mục</label>
                                                <ui-select class="" remove-selected="true"
                                                    ng-model="form.category_id" theme="select2">
                                                    <ui-select-match placeholder="Chọn danh mục">
                                                        <% $select.selected.name %>
                                                    </ui-select-match>
                                                    <ui-select-choices
                                                        repeat="t.id as t in (form.all_categories | filter: $select.search)">
                                                        <span ng-bind="t.name"></span>
                                                    </ui-select-choices>
                                                </ui-select>
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong><% errors.cate_id[0] %></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Tên dự án</label>
                                                <span class="text-danger">(*)</span>
                                                <input class="form-control" type="text" ng-model="form.title">
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong><% errors['title'][0] %></strong>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Địa điểm</label>
                                                <input class="form-control" type="text" ng-model="form.address">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Giới thiệu ngắn</label>
                                                <span class="text-danger">(*)</span>
                                                <textarea id="editor" class="form-control" ck-editor ng-model="form.short_des" rows="4"></textarea>
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong><% errors['short_des'][0] %></strong>
                                                </span>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Chi tiết</label>
                                                <span class="text-danger">(*)</span>
                                                <textarea id="editor" class="form-control" ck-editor ng-model="form.des" rows="4"></textarea>
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong><% errors['des'][0] %></strong>
                                                </span>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-4 col-xs-12">
        {{--		<div class="form-group custom-group mb-4"> --}}
        {{--			<label class="form-label required-label">Trạng thái</label> --}}
        {{--			<select select2 class="form-control" ng-model="form.status"> --}}
        {{--				<option value="">Chọn trạng thái</option> --}}
        {{--				<option ng-repeat="s in form.statuses" ng-value="s.id" ng-selected="form.status == s.id"><% s.name %></option> --}}
        {{--			</select> --}}
        {{--		</div> --}}
        <div class="form-group custom-group mb-4">
            <label class="form-label required-label">Hiển thị ngoài trang chủ</label>
            <select id="my-select" class="form-control custom-select" ng-model="form.show_home_page">
                <option ng-repeat="s in show_home_page" ng-value="s.value" ng-selected="form.show_home_page == s.value"><% s.name %></option>

            </select>
            <span class="invalid-feedback d-block" role="alert">
                <strong><% errors.show_home_page[0] %></strong>
            </span>
        </div>
        <div class="form-group text-center mb-4">
            <div class="main-img-preview">
                <p class="help-block-img">* Ảnh định dạng: jpg, png không quá 2MB.</p>
                <img class="thumbnail img-preview" ng-src="<% form.image.path %>">
            </div>
            <div class="input-group" style="width: 100%; text-align: center">
                <div class="input-group-btn" style="margin: 0 auto">
                    <div class="fileUpload fake-shadow cursor-pointer">
                        <label class="mb-0" for="<% form.image.element_id %>">
                            <i class="glyphicon glyphicon-upload"></i> Chọn ảnh
                        </label>
                        <input class="d-none" id="<% form.image.element_id %>" type="file" class="attachment_upload"
                            accept=".jpg,.jpeg,.png">
                    </div>
                </div>
            </div>
            <span class="invalid-feedback d-block" role="alert">
                <strong><% errors.image[0] %></strong>
            </span>
        </div>
        <hr>
        <div class="form-group text-center">
            <label for="">Gallery ảnh</label>
            <div class="row gallery-area border">
                <div class="col-md-4 p-2" ng-repeat="g in form.galleries">
                    <div class="gallery-item">
                        <button class="btn btn-sm btn-danger remove" ng-click="form.removeGallery($index)">
                            <i class="fa fa-times mr-0"></i>
                        </button>
                        <div class="form-group">
                            <div class="img-chooser" title="Chọn ảnh">
                                <label for="<% g.image.element_id %>">
                                    <img ng-src="<% g.image.path %>">
                                    <input class="d-none" type="file" accept=".jpg,.png,.jpeg" id="<% g.image.element_id %>">
                                </label>
                            </div>
                            <span class="invalid-feedback d-block" role="alert" ng-if="!errors['galleries.' + $index + '.image_obj']">
                                <strong>
                                    <% errors['galleries.' + $index + '.image' ][0] %>
                                </strong>
                            </span>
                            <span class="invalid-feedback">
                                <strong>
                                    <% errors['galleries.' + $index + '.image_obj' ][0] %>
                                </strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-2">
                    <label class="gallery-item d-flex align-items-center justify-content-center cursor-pointer" for="gallery-chooser">
                        <i class="fa fa-plus fa-2x text-secondary"></i>
                    </label>
                    <input class="d-none" type="file" accept=".jpg,.png,.jpeg" id="gallery-chooser" multiple>
                </div>
            </div>
            <span class="invalid-feedback">
                <strong>
                    <% errors.galleries[0] %>
                </strong>
            </span>
        </div>
    </div>
</div>

<hr>
<div class="text-right">
    <button type="submit" class="btn btn-success btn-cons" ng-click="submit(0)" ng-disabled="loading.submit">
        <i ng-if="!loading.submit" class="fa fa-save"></i>
        <i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
        Lưu
    </button>
    <a href="{{ route('Project.index') }}" class="btn btn-danger btn-cons">
        <i class="fa fa-remove"></i> Hủy
    </a>
</div>
