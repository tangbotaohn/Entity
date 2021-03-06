<script type="text/x-template" id="tttField">
    <table class="table table-striped table-bordered">
        <caption>
            <h3>Field</h3>
        </caption>
        <thead>
        <tr>
            <th width="150px"></th>
            <th width="180px">Name</th>
            <th>Type</th>
            <th>Length</th>
            <th>Default</th>
            <th>Comment</th>
            <th>Nullable</th>
            <th>Unsigned</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="field in table.field.list">
            <td>
                <div class="btn-group">
                    <button v-on:click="table.field.moveUp(field)" class="btn btn-info" type="button">↑</button>
                    <button v-on:click="table.field.moveDown(field)" class="btn btn-info" type="button">↓</button>
                </div>
                <button v-on:click="remove(field)" class="btn btn-danger" type="button">X</button>
            </td>
            <td>
                <button v-on:click="rename(field)" class="btn btn-default" type="button">@brace('field.name')</button>
            </td>
            <td>
                <select v-model="field.type" class="form-control">
                    <option value="bigIncrements">bigIncrements</option>
                    <option value="bigInteger">bigInteger</option>
                    <option value="binary">binary</option>
                    <option value="boolean">boolean</option>
                    <option value="char">char</option>
                    <option value="date">date</option>
                    <option value="dateTime">dateTime</option>
                    <option value="decimal">decimal</option>
                    <option value="double">double</option>
                    <option value="enum">enum</option>
                    <option value="float">float</option>
                    <option value="increments">increments</option>
                    <option value="integer">integer</option>
                    <option value="json">json</option>
                    <option value="jsonb">jsonb</option>
                    <option value="longText">longText</option>
                    <option value="mediumInteger">mediumInteger</option>
                    <option value="mediumText">mediumText</option>
                    <option value="morphs">morphs</option>
                    <option value="smallInteger">smallInteger</option>
                    <option value="string">string</option>
                    <option value="text">text</option>
                    <option value="time">time</option>
                    <option value="tinyInteger">tinyInteger</option>
                    <option value="timestamp">timestamp</option>
                    <option value="uuid">uuid</option>
                </select>
            </td>
            <td><input v-model="field.length" class="form-control" type="text"></td>
            <td><input v-model="field.default" class="form-control" type="text"></td>
            <td><input v-model="field.comment" class="form-control" type="text"></td>
            <td><input v-model="field.nullable" class="form-control" type="checkbox"></td>
            <td><input v-model="field.unsigned" class="form-control" type="checkbox"></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td>
                <button v-on:click="add" class="btn btn-primary" type="button">+</button>
            </td>
            <td>
                <select v-model="selectedField" class="form-control pull-left" style="width: auto; margin-right: 9px">
                    <option v-for="field in fieldList" v-bind:value="field">@brace('field.name')</option>
                </select>
                <button v-on:click="addField" class="btn btn-info" type="button"> + </button>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</script>


<script type="text/javascript">

    const fieldList = [
        new Field('id', 'increments'),
        new Field('user_id', 'integer'),
        new Field('name', 'string'),
        new Field('status', 'integer'),
        new Field('created_at', 'timestamp'),
        new Field('updated_at', 'timestamp'),
        new Field('deleted_at', 'timestamp')
    ];

    Vue.component('ccc-field', {
        template: '#tttField',
        props: ['table'],
        data: function () {
            return {
                fieldList: fieldList,
                selectedField: fieldList[0]
            }
        },
        methods: {
            add: function () {
                let name = input('Please enter the Field name');
                if (isEmpty(name)) {
                    return;
                }
                this.table.field.create(name, 'integer');
            },
            remove: function (field) {
                if (sure('Are you sure?')) {
                    this.table.field.remove(field);
                }
            },
            rename: function (field) {
                let name = input('Please enter the Field name');
                if (isEmpty(name)) {
                    return;
                }
                this.table.changeFieldName(field, name);
            },
            addField: function () {
                let one = this.table.field.create(this.selectedField.name, this.selectedField.type);

                let nullList = ['deleted_at', 'created_at', 'updated_at'];
                for (let index in nullList) {
                    if (nullList[index] == one.name) {
                        one.nullable = true;
                        return;
                    }
                }
            }
        }
    });

</script>
