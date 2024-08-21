@extends('layout.admin')
@section('content')

    <div class="row">


        <div class="col-lg-12 col-ml-12">
            <div class="row">
                <!-- basic form start -->

                <div class="col-12 mt-5 start-form-sec">

                    <div class="card">
                        <div class="card-body">

                            <!-- <h4 class="header-title">Basic form</h4> -->
                            <p id="err" style="color:red;"></p>

                            <form id="productForm" method="post"
                                action="@if (isset($editStatus)) {{ route('product.update', $product->id) }} @else {{ route('product.store') }} @endif"
                                enctype='multipart/form-data'>

                                {{ csrf_field() }}

                                @if (isset($editStatus))
                                    @method('PUT')
                                @endif


                                @if (session()->has('message'))
                                    <div class="alert alert-danger">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif


                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                                <div class="row">

                                    <div class="col-6 mt-5">
                                        <div class="form-group">
                                            <label for="categoryId">Product Category</label>
                                            <select class="form-control selectpicker" id="categoryId" name="categoryId"
                                                data-live-search="true">
                                                <option value="">Select Category</option>
                                                @if (isset($productCategory))
                                                    @foreach ($productCategory as $value)
                                                        <option value="{{ $value->id }}"
                                                            @if (old('categoryId', isset($product->category_id) ? $product->category_id : null) == $value->id) selected="selected" @endif>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6 mt-5">
                                        <div class="form-group">
                                            <label for="type">Product Type</label>
                                            <select class="form-control selectpicker" id="type" name="type"
                                                data-live-search="true">
                                                <option value="">Select Type</option>
                                                <option value="0"
                                                    @if (old('type', isset($product->type) ? $product->type : null) == '0') selected="selected" @endif>Normal
                                                </option>
                                                <option value="1"
                                                    @if (old('type', isset($product->type) ? $product->type : null) == '1') selected="selected" @endif>
                                                    Configurable</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-6 mt-5">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Enter product name"
                                                value="{{ old('name', isset($product->name) ? $product->name : null) }}">
                                        </div>
                                    </div>



                                    <div class="col-6 mt-5">
                                        <div class="form-group">
                                            <label for="price">Base Price</label>
                                            <input type="text" class="form-control" id="price" name="price"
                                                placeholder="Enter product price"
                                                value="{{ old('price', isset($product->price) ? $product->price : null) }}">
                                        </div>
                                    </div>

                                    <div class="col-6 mt-5">
                                        <div class="form-group">
                                            <label for="image">Thumbnail</label>
                                            <input type="file" id="image" name="image" class="form-control"
                                                value="{{ old('image', isset($product->image->id) ? $product->image->id : null) }}">
                                        </div>
                                    </div>


                                    @if (isset($product->image->name))
                                        <div class="col-12 mt-6">
                                            <div class="upload-image">
                                                <img width="100" height="60"
                                                    src=" {{ URL::to('/') }}/uploads/productImage/{{ $product->image->name }}"
                                                    alt="image">
                                            </div>
                                        </div>
                                    @endif
                                </div>


                                <div class="row">
                                    <div id="productAttributesSection" class="col-12" style="display: none">
                                        <div class="mt-3">
                                            <span id="applyMessage"
                                                style="color:black; background-color: #cef5d3; display: none"
                                                class="p-2 m-2"></span>
                                            <div class="form-group m-3">
                                                <label>Product Attributes</label>
                                                <div class="row" id="attributesContainer">
                                                    @if (isset($attributes))
                                                        @foreach ($attributes as $attribute)
                                                            <div class="col-lg-3 col-md-4 col-sm-6 col-12 m-2">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="attributes[]"
                                                                        id="attribute_{{ $attribute->id }}"
                                                                        value="{{ $attribute->id }}"
                                                                        @if (old('attributes') && in_array($attribute->id, old('attributes'))) checked
                                                                        @elseif (isset($product) && $product->productAttributes->contains('attribute_id', $attribute->id))
                                                                            checked @endif>
                                                                    <label class="form-check-label"
                                                                        for="attribute_{{ $attribute->id }}">
                                                                        {{ $attribute->name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-12 mt-5 mb-3">
                                                <button id="applyAttributesBtn" class="btn btn-primary pr-4 pl-4"
                                                    disabled>Apply Attributes</button>
                                                <button id="addMore" class="btn btn-primary pr-4 pl-4">Add Row</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mx-3" id="variationDiv">
                                        <div class="col-12 mt-5 mb-3 pt-2 border" id="attributeOptions"
                                            style="{{ isset($product) ? '' : 'display: none;' }} background-color: #ddeaf7; box-shadow: 0 0 15px 5px rgba(0, 0, 0, 0.1);">
                                            <table class="table">
                                                <tbody id="productRows" class="variation">
                                                    @if (isset($product) && $product->productVariation->isNotEmpty())
                                                        @foreach ($product->productVariation as $index => $variation)
                                                            <tr class="variation_{{ $index }}" data-index="{{ $index }}">
                                                                <td class="col-lg-3 col-md-4 col-sm-6 col-12 p-1">
                                                                    <input class="form-control form-control-sm"
                                                                        name="variation[{{ $index }}][sku]"
                                                                        value="{{ $variation->sku }}"
                                                                        placeholder="Enter SKU" />
                                                                </td>
                                                                <td class="col-lg-3 col-md-4 col-sm-6 col-12 p-1">
                                                                    <input class="form-control form-control-sm"
                                                                        name="variation[{{ $index }}][price]"
                                                                        value="{{ $variation->price }}"
                                                                        placeholder="Enter Product Price" />
                                                                </td>
                                                                <td class="col-lg-3 col-md-4 col-sm-6 col-12 p-1">
                                                                    <input class="form-control form-control-sm"
                                                                        name="variation[{{ $index }}][stock]"
                                                                        value="{{ $variation->stock }}"
                                                                        placeholder="Enter Stock" />
                                                                </td>
                                                                @foreach ($product->productAttributes as $attribute)
                                                                    <td class="col-lg-3 col-md-4 col-sm-6 col-12 p-1">
                                                                        <select
                                                                            name="variation[{{ $index }}][attributeOptions][]"
                                                                            class="form-control form-control-sm selectpicker attributes_{{ $attribute->attribute_id }}">
                                                                            <option value="">Select {{ $attribute->attribute->name }}</option>
                                                                            @foreach ($attribute->attribute->options as $option)
                                                                                <option value="{{ $option->id }}"
                                                                                    {{ $variation->attributes->contains('attributes_options_id', $option->id) ? 'selected' : '' }}>
                                                                                    {{ $option->value }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                @endforeach
                                                                <td class="col-lg-3 col-md-4 col-sm-6 col-12 p-1 delete-row">
                                                                    <i class="fa fa-trash fa-2x delete-icon cursor-pointer" aria-hidden="true"></i>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-12 mt-10">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control ckeditor" id="description" name="description" placeholder="Enter Description">{{ old('description', isset($product->description) ? $product->description : null) }}</textarea>
                                        </div>

                                        @if (isset($product->id))
                                            <input type="hidden" name="id" id="productId"
                                                value="{{ $product->id }}">
                                        @endif

                                        <button type="submit" class="btn btn-primary mt-3 pr-4 pl-4">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- basic form end -->
            </div>
        </div>
    </div>

@section('js')
    <script src="{{ asset('assets/admin/js/console/product.js') }}"></script>
@append

<script type="text/javascript">
    var productId = "{{ isset($product->id) ? $product->id : '' }}";

    var editstatus = "{{ isset($editStatus) ? 1 : 0 }}";
    console.log(editstatus);

    var attributeIndex = $('#productRows tr').length;
    // var rowcount = {{ isset($rowcount) ? $rowcount : 0 }};
     console.log(attributeIndex);

    // let attributeIndex = 0;
    // console.log(attributeIndex);
    // if (editstatus == 1) {
    //     attributeIndex = rowcount;
    //     console.log(attributeIndex);

    // } else {
    //     attributeIndex = 0;
    //     console.log(attributeIndex);

    // }

    $(document).ready(function() {

        $("#productForm").submit(function() {

            if ($("#categoryId").val() == "") {
                $("#err").text("Please select product category");
                $("#categoryId").focus();
                return false;
            }
            if ($("#name").val() == "") {
                $("#err").text("Please enter product name");
                $("#name").focus();
                return false;
            }
            if ($("#price").val() == "") {
                $("#err").text("Please enter product price");
                $("#price").focus();
                return false;
            }
            // if ($("#image").val() == "") {
            //     $("#err").text("Please select image");
            //     $("#image").focus();
            //     return false;
            // }
        });

        if ($('#type').val() == '1') {
            $('#productAttributesSection').show();
        }

        $('#type').on('change', function() {
            if ($(this).val() == '1') {
                $('#productAttributesSection').show();
                $('#variationDiv').show();
            } else {
                $('#productAttributesSection').hide();
                $('#variationDiv').hide();
            }
        });

        function updateButtonState() {
            var checkedCount = $('#attributesContainer .form-check-input:checked').length;
            $('#applyAttributesBtn').prop('disabled', checkedCount === 0);
        }

        $('#attributesContainer .form-check-input').on('change', updateButtonState);
        updateButtonState();


        $('#applyAttributesBtn').on('click', function(event) {
            event.preventDefault();

            $(this).prop('disabled', true);
            // $('#addMore').prop('disabled', false);

            $('input[name="attributes[]"]').prop('disabled', true);

            var selectedAttributes = [];

            $('input[name="attributes[]"]:checked').each(function() {
                selectedAttributes.push($(this).val());
            });

            console.log(selectedAttributes);

            $.ajax({
                type: 'POST',
                url: '/admin/product/getAttributeOptions',
                data: {
                    attributes: selectedAttributes,
                    editStatus: editstatus,
                    productId: productId,
                    index: attributeIndex
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        var selectedAttributes = response.response.selectedAttributes;
                        var prevAttributes = response.response.prevAttributes;
                        var newAttributes = response.response.newSelectedAttribute;
                        var attributeOptions = response.response.attributeOptions;
                        //var deletedAttributes = response.response.deletedAttributes;
                        var html = response.response.html;
                        var attributesToRemove = response.response.attributesToRemove;
                        console.log(attributesToRemove);
                        var index = response.response.index;
                         console.log(index);
                        console.log(prevAttributes);
                        console.log(newAttributes);
                        console.log(attributeOptions);
                        console.log(response);

                        if (response.response.page == 0) {
                            $('#applyMessage').text('Attribute Applied Successfully');
                            $('#applyMessage').show();
                        } else if (response.response.page == 1) {
                            $('#applyMessage').text('Attribute Updated Successfully');

                            if (attributesToRemove) {
                                Object.values(attributesToRemove).forEach(
                                    function(
                                        attributeId) {


                                        $('select[class*="attributes_' + attributeId +
                                            '"]').each(function() {
                                            $(this).closest('td').remove();
                                        });

                                    });
                            }
                            if (html) {
                                $('#productRows tr').each(function() {
                                    $(this).find('td').eq(-1).before(html);
                                });
                            }

                            $('.selectpicker').selectpicker('refresh');

                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }

            });
        });

        $('#addMore').on('click', function(event) {
            event.preventDefault();

            $.ajax({
                url: '/admin/product/add-more',
                type: 'POST',
                data: {
                    index: attributeIndex,
                    productId: productId,
                    editStatus: editstatus
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {

                        $('#productRows').append(response.response.html);

                        $('.selectpicker').selectpicker('refresh');
                        $('#attributeOptions').show();

                        attributeIndex = response.response.index;
                        console.log(attributeIndex);
                    } else {
                        console.error('Failed to fetch attribute options.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ', status, error);
                }
            });
        });
        $(document).on('click', '.delete-icon', function() {
            $(this).closest('tr').remove();
        });

    });
</script>

@endsection
