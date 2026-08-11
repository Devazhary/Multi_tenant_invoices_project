<!-- Modal effects -->
<div class="modal" id="edit_product">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">تعديل المنتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="products/update" method="POST" id="edit_product_form" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_product_name">اسم المنتج</label>
                        <input type="text" class="form-control" id="edit_product_name" name="product_name"
                            placeholder="ادخل اسم المنتج" required>
                        @if ($errors->has('product_name'))
                            <span class="text-danger">{{ $errors->first('product_name') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="section_id">القسم</label>
                        <select class="form-control" id="section_id" name="section_id" required>
                            <option value="" disabled>اختر القسم</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('section_id'))
                            <span class="text-danger">{{ $errors->first('section_id') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="edit_description">الوصف</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3" placeholder="ادخل وصف المنتج"></textarea>
                        @if ($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">إلغاء</button>
                    <button class="btn ripple btn-primary" type="submit">حفظ</button>
                </div>

            </form>

        </div>
    </div>
</div>
<!-- End Modal effects-->
