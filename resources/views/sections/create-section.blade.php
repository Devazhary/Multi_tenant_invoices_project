<!-- Modal effects -->
<div class="modal" id="create_section">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">اضافة قسم جديد</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('sections.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="section_name">اسم القسم</label>
                        <input type="text" class="form-control" id="section_name" name="section_name"
                            placeholder="ادخل اسم القسم" required>
                        @if($errors->has('section_name'))
                            <span class="text-danger">{{ $errors->first('section_name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="description">الوصف</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                            placeholder="ادخل وصف القسم"></textarea>
                            @if($errors->has('description'))
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
