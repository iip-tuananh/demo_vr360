<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group custom-group">
                    <label class="form-label required-label">Tên người sáng lập</label>
                    <input class="form-control " type="text" ng-model="form.name">
                    <span class="invalid-feedback d-block" role="alert">
                        <strong><% errors.name[0] %></strong>
                    </span>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group custom-group">
                    <label class="form-label">Vị trí người sáng lập</label>
                    <input class="form-control " type="text" ng-model="form.position">
                    <span class="invalid-feedback d-block" role="alert">
                        <strong><% errors.position[0] %></strong>
                    </span>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group custom-group">
                    <label class="form-label">Mô tả</label>
                    <textarea id="my-textarea" class="form-control" ng-model="form.description" rows="3"></textarea>
                    <span class="invalid-feedback d-block" role="alert">
                        <strong><% errors.description[0] %></strong>
                    </span>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group custom-group">
                    <label class="form-label">Link Facebook</label>
                    <input class="form-control " type="text" ng-model="form.link_facebook">
                    <span class="invalid-feedback d-block" role="alert">
                        <strong><% errors.link_facebook[0] %></strong>
                    </span>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group custom-group">
                    <label class="form-label">Link Instagram</label>
                    <input class="form-control " type="text" ng-model="form.link_instagram">
                    <span class="invalid-feedback d-block" role="alert">
                        <strong><% errors.link_instagram[0] %></strong>
                    </span>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group custom-group">
                    <label class="form-label">Link Website</label>
                    <input class="form-control " type="text" ng-model="form.link_website">
                    <span class="invalid-feedback d-block" role="alert">
                        <strong><% errors.link_website[0] %></strong>
                    </span>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group custom-group">
                    <label class="form-label">Số điện thoại</label>
                    <input class="form-control " type="text" ng-model="form.phone">
                    <span class="invalid-feedback d-block" role="alert">
                        <strong><% errors.phone[0] %></strong>
                    </span>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group custom-group">
                    <label class="form-label">Email</label>
                    <input class="form-control " type="text" ng-model="form.email">
                    <span class="invalid-feedback d-block" role="alert">
                        <strong><% errors.email[0] %></strong>
                    </span>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group custom-group">
                    <label class="form-label">Zalo</label>
                    <input class="form-control " type="text" ng-model="form.zalo">
                    <span class="invalid-feedback d-block" role="alert">
                        <strong><% errors.zalo[0] %></strong>
                    </span>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
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
                                <input class="d-none" id="<% form.image.element_id %>" type="file"
                                    class="attachment_upload" accept=".jpg,.jpeg,.png">
                            </div>
                        </div>
                    </div>
                    <span class="invalid-feedback d-block" role="alert">
                        <strong><% errors.image[0] %></strong>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
