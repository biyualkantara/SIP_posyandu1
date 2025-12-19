import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\DuspyController::index
* @see app/Http/Controllers/DuspyController.php:14
* @route '/posyandu/data-umum'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/posyandu/data-umum',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DuspyController::index
* @see app/Http/Controllers/DuspyController.php:14
* @route '/posyandu/data-umum'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::index
* @see app/Http/Controllers/DuspyController.php:14
* @route '/posyandu/data-umum'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::index
* @see app/Http/Controllers/DuspyController.php:14
* @route '/posyandu/data-umum'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\DuspyController::index
* @see app/Http/Controllers/DuspyController.php:14
* @route '/posyandu/data-umum'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::index
* @see app/Http/Controllers/DuspyController.php:14
* @route '/posyandu/data-umum'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::index
* @see app/Http/Controllers/DuspyController.php:14
* @route '/posyandu/data-umum'
*/
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index.form = indexForm

/**
* @see \App\Http\Controllers\DuspyController::create
* @see app/Http/Controllers/DuspyController.php:63
* @route '/posyandu/data-umum/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/posyandu/data-umum/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DuspyController::create
* @see app/Http/Controllers/DuspyController.php:63
* @route '/posyandu/data-umum/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::create
* @see app/Http/Controllers/DuspyController.php:63
* @route '/posyandu/data-umum/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::create
* @see app/Http/Controllers/DuspyController.php:63
* @route '/posyandu/data-umum/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\DuspyController::create
* @see app/Http/Controllers/DuspyController.php:63
* @route '/posyandu/data-umum/create'
*/
const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::create
* @see app/Http/Controllers/DuspyController.php:63
* @route '/posyandu/data-umum/create'
*/
createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::create
* @see app/Http/Controllers/DuspyController.php:63
* @route '/posyandu/data-umum/create'
*/
createForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: create.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

create.form = createForm

/**
* @see \App\Http\Controllers\DuspyController::storeMultiple
* @see app/Http/Controllers/DuspyController.php:79
* @route '/posyandu/data-umum/store-multiple'
*/
export const storeMultiple = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeMultiple.url(options),
    method: 'post',
})

storeMultiple.definition = {
    methods: ["post"],
    url: '/posyandu/data-umum/store-multiple',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\DuspyController::storeMultiple
* @see app/Http/Controllers/DuspyController.php:79
* @route '/posyandu/data-umum/store-multiple'
*/
storeMultiple.url = (options?: RouteQueryOptions) => {
    return storeMultiple.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::storeMultiple
* @see app/Http/Controllers/DuspyController.php:79
* @route '/posyandu/data-umum/store-multiple'
*/
storeMultiple.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeMultiple.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\DuspyController::storeMultiple
* @see app/Http/Controllers/DuspyController.php:79
* @route '/posyandu/data-umum/store-multiple'
*/
const storeMultipleForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: storeMultiple.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\DuspyController::storeMultiple
* @see app/Http/Controllers/DuspyController.php:79
* @route '/posyandu/data-umum/store-multiple'
*/
storeMultipleForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: storeMultiple.url(options),
    method: 'post',
})

storeMultiple.form = storeMultipleForm

/**
* @see \App\Http\Controllers\DuspyController::exportPdf
* @see app/Http/Controllers/DuspyController.php:0
* @route '/posyandu/data-umum/export-pdf'
*/
export const exportPdf = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportPdf.url(options),
    method: 'get',
})

exportPdf.definition = {
    methods: ["get","head"],
    url: '/posyandu/data-umum/export-pdf',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DuspyController::exportPdf
* @see app/Http/Controllers/DuspyController.php:0
* @route '/posyandu/data-umum/export-pdf'
*/
exportPdf.url = (options?: RouteQueryOptions) => {
    return exportPdf.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::exportPdf
* @see app/Http/Controllers/DuspyController.php:0
* @route '/posyandu/data-umum/export-pdf'
*/
exportPdf.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportPdf.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::exportPdf
* @see app/Http/Controllers/DuspyController.php:0
* @route '/posyandu/data-umum/export-pdf'
*/
exportPdf.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: exportPdf.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\DuspyController::exportPdf
* @see app/Http/Controllers/DuspyController.php:0
* @route '/posyandu/data-umum/export-pdf'
*/
const exportPdfForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: exportPdf.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::exportPdf
* @see app/Http/Controllers/DuspyController.php:0
* @route '/posyandu/data-umum/export-pdf'
*/
exportPdfForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: exportPdf.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::exportPdf
* @see app/Http/Controllers/DuspyController.php:0
* @route '/posyandu/data-umum/export-pdf'
*/
exportPdfForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: exportPdf.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

exportPdf.form = exportPdfForm

/**
* @see \App\Http\Controllers\DuspyController::show
* @see app/Http/Controllers/DuspyController.php:117
* @route '/posyandu/data-umum/{id}'
*/
export const show = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/posyandu/data-umum/{id}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DuspyController::show
* @see app/Http/Controllers/DuspyController.php:117
* @route '/posyandu/data-umum/{id}'
*/
show.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return show.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::show
* @see app/Http/Controllers/DuspyController.php:117
* @route '/posyandu/data-umum/{id}'
*/
show.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::show
* @see app/Http/Controllers/DuspyController.php:117
* @route '/posyandu/data-umum/{id}'
*/
show.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\DuspyController::show
* @see app/Http/Controllers/DuspyController.php:117
* @route '/posyandu/data-umum/{id}'
*/
const showForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::show
* @see app/Http/Controllers/DuspyController.php:117
* @route '/posyandu/data-umum/{id}'
*/
showForm.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::show
* @see app/Http/Controllers/DuspyController.php:117
* @route '/posyandu/data-umum/{id}'
*/
showForm.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

/**
* @see \App\Http\Controllers\DuspyController::edit
* @see app/Http/Controllers/DuspyController.php:126
* @route '/posyandu/data-umum/{id}/edit'
*/
export const edit = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/posyandu/data-umum/{id}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DuspyController::edit
* @see app/Http/Controllers/DuspyController.php:126
* @route '/posyandu/data-umum/{id}/edit'
*/
edit.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return edit.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::edit
* @see app/Http/Controllers/DuspyController.php:126
* @route '/posyandu/data-umum/{id}/edit'
*/
edit.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::edit
* @see app/Http/Controllers/DuspyController.php:126
* @route '/posyandu/data-umum/{id}/edit'
*/
edit.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\DuspyController::edit
* @see app/Http/Controllers/DuspyController.php:126
* @route '/posyandu/data-umum/{id}/edit'
*/
const editForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::edit
* @see app/Http/Controllers/DuspyController.php:126
* @route '/posyandu/data-umum/{id}/edit'
*/
editForm.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DuspyController::edit
* @see app/Http/Controllers/DuspyController.php:126
* @route '/posyandu/data-umum/{id}/edit'
*/
editForm.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: edit.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

edit.form = editForm

/**
* @see \App\Http\Controllers\DuspyController::update
* @see app/Http/Controllers/DuspyController.php:146
* @route '/posyandu/data-umum/{id}'
*/
export const update = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/posyandu/data-umum/{id}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\DuspyController::update
* @see app/Http/Controllers/DuspyController.php:146
* @route '/posyandu/data-umum/{id}'
*/
update.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return update.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::update
* @see app/Http/Controllers/DuspyController.php:146
* @route '/posyandu/data-umum/{id}'
*/
update.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\DuspyController::update
* @see app/Http/Controllers/DuspyController.php:146
* @route '/posyandu/data-umum/{id}'
*/
const updateForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\DuspyController::update
* @see app/Http/Controllers/DuspyController.php:146
* @route '/posyandu/data-umum/{id}'
*/
updateForm.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

/**
* @see \App\Http\Controllers\DuspyController::destroy
* @see app/Http/Controllers/DuspyController.php:204
* @route '/posyandu/data-umum/{id}'
*/
export const destroy = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/posyandu/data-umum/{id}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\DuspyController::destroy
* @see app/Http/Controllers/DuspyController.php:204
* @route '/posyandu/data-umum/{id}'
*/
destroy.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return destroy.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\DuspyController::destroy
* @see app/Http/Controllers/DuspyController.php:204
* @route '/posyandu/data-umum/{id}'
*/
destroy.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\DuspyController::destroy
* @see app/Http/Controllers/DuspyController.php:204
* @route '/posyandu/data-umum/{id}'
*/
const destroyForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \App\Http\Controllers\DuspyController::destroy
* @see app/Http/Controllers/DuspyController.php:204
* @route '/posyandu/data-umum/{id}'
*/
destroyForm.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

const dataUmum = {
    index: Object.assign(index, index),
    create: Object.assign(create, create),
    storeMultiple: Object.assign(storeMultiple, storeMultiple),
    exportPdf: Object.assign(exportPdf, exportPdf),
    show: Object.assign(show, show),
    edit: Object.assign(edit, edit),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
}

export default dataUmum