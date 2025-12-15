import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\BayiController::getBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata'
 */
export const getBiodata = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getBiodata.url(options),
    method: 'get',
})

getBiodata.definition = {
    methods: ["get","head"],
    url: '/api/bayi/biodata',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::getBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata'
 */
getBiodata.url = (options?: RouteQueryOptions) => {
    return getBiodata.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::getBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata'
 */
getBiodata.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getBiodata.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\BayiController::getBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata'
 */
getBiodata.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getBiodata.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\BayiController::getBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata'
 */
    const getBiodataForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: getBiodata.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\BayiController::getBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata'
 */
        getBiodataForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: getBiodata.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\BayiController::getBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata'
 */
        getBiodataForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: getBiodata.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    getBiodata.form = getBiodataForm
/**
* @see \App\Http\Controllers\BayiController::postBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata'
 */
export const postBiodata = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: postBiodata.url(options),
    method: 'post',
})

postBiodata.definition = {
    methods: ["post"],
    url: '/api/bayi/biodata',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\BayiController::postBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata'
 */
postBiodata.url = (options?: RouteQueryOptions) => {
    return postBiodata.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::postBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata'
 */
postBiodata.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: postBiodata.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\BayiController::postBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata'
 */
    const postBiodataForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: postBiodata.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\BayiController::postBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata'
 */
        postBiodataForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: postBiodata.url(options),
            method: 'post',
        })
    
    postBiodata.form = postBiodataForm
/**
* @see \App\Http\Controllers\BayiController::updateBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata/{id}'
 */
export const updateBiodata = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateBiodata.url(args, options),
    method: 'put',
})

updateBiodata.definition = {
    methods: ["put"],
    url: '/api/bayi/biodata/{id}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\BayiController::updateBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata/{id}'
 */
updateBiodata.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return updateBiodata.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::updateBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata/{id}'
 */
updateBiodata.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateBiodata.url(args, options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\BayiController::updateBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata/{id}'
 */
    const updateBiodataForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: updateBiodata.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\BayiController::updateBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata/{id}'
 */
        updateBiodataForm.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: updateBiodata.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    updateBiodata.form = updateBiodataForm
/**
* @see \App\Http\Controllers\BayiController::deleteBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata/{id}'
 */
export const deleteBiodata = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteBiodata.url(args, options),
    method: 'delete',
})

deleteBiodata.definition = {
    methods: ["delete"],
    url: '/api/bayi/biodata/{id}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\BayiController::deleteBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata/{id}'
 */
deleteBiodata.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return deleteBiodata.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::deleteBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata/{id}'
 */
deleteBiodata.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteBiodata.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\BayiController::deleteBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata/{id}'
 */
    const deleteBiodataForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: deleteBiodata.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\BayiController::deleteBiodata
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/biodata/{id}'
 */
        deleteBiodataForm.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: deleteBiodata.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    deleteBiodata.form = deleteBiodataForm
/**
* @see \App\Http\Controllers\BayiController::getPenimbangan
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/penimbangan'
 */
export const getPenimbangan = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getPenimbangan.url(options),
    method: 'get',
})

getPenimbangan.definition = {
    methods: ["get","head"],
    url: '/api/bayi/penimbangan',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::getPenimbangan
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/penimbangan'
 */
getPenimbangan.url = (options?: RouteQueryOptions) => {
    return getPenimbangan.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::getPenimbangan
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/penimbangan'
 */
getPenimbangan.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getPenimbangan.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\BayiController::getPenimbangan
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/penimbangan'
 */
getPenimbangan.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getPenimbangan.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\BayiController::getPenimbangan
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/penimbangan'
 */
    const getPenimbanganForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: getPenimbangan.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\BayiController::getPenimbangan
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/penimbangan'
 */
        getPenimbanganForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: getPenimbangan.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\BayiController::getPenimbangan
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/penimbangan'
 */
        getPenimbanganForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: getPenimbangan.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    getPenimbangan.form = getPenimbanganForm
/**
* @see \App\Http\Controllers\BayiController::getImunisasi
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/imunisasi'
 */
export const getImunisasi = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getImunisasi.url(options),
    method: 'get',
})

getImunisasi.definition = {
    methods: ["get","head"],
    url: '/api/bayi/imunisasi',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::getImunisasi
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/imunisasi'
 */
getImunisasi.url = (options?: RouteQueryOptions) => {
    return getImunisasi.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::getImunisasi
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/imunisasi'
 */
getImunisasi.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getImunisasi.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\BayiController::getImunisasi
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/imunisasi'
 */
getImunisasi.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getImunisasi.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\BayiController::getImunisasi
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/imunisasi'
 */
    const getImunisasiForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: getImunisasi.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\BayiController::getImunisasi
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/imunisasi'
 */
        getImunisasiForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: getImunisasi.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\BayiController::getImunisasi
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/imunisasi'
 */
        getImunisasiForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: getImunisasi.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    getImunisasi.form = getImunisasiForm
/**
* @see \App\Http\Controllers\BayiController::getKematian
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/kematian'
 */
export const getKematian = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getKematian.url(options),
    method: 'get',
})

getKematian.definition = {
    methods: ["get","head"],
    url: '/api/bayi/kematian',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\BayiController::getKematian
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/kematian'
 */
getKematian.url = (options?: RouteQueryOptions) => {
    return getKematian.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\BayiController::getKematian
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/kematian'
 */
getKematian.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getKematian.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\BayiController::getKematian
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/kematian'
 */
getKematian.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getKematian.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\BayiController::getKematian
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/kematian'
 */
    const getKematianForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: getKematian.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\BayiController::getKematian
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/kematian'
 */
        getKematianForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: getKematian.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\BayiController::getKematian
 * @see app/Http/Controllers/BayiController.php:0
 * @route '/api/bayi/kematian'
 */
        getKematianForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: getKematian.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    getKematian.form = getKematianForm
const BayiController = { getBiodata, postBiodata, updateBiodata, deleteBiodata, getPenimbangan, getImunisasi, getKematian }

export default BayiController