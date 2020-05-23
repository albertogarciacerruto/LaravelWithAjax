<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Category;

class PrincipalController extends Controller
{
    //Funciòn para listar todos las tareas registradas
    public function index()
    {
        $list_items = \DB::select("SELECT items.name, GROUP_CONCAT(DISTINCT categories.name) AS category, GROUP_CONCAT(DISTINCT items.id) AS id FROM items, categories, category_item WHERE category_item.id_item = items.id AND category_item.id_category = categories.id GROUP BY 1");
        return view('principal', compact('list_items'));
    }
    
    //Funciòn para llamar a la funcion de registro
    public function register()
    {
        return view('principal');
    }

    //Funciòn para registrar
    public function store(Request $request)
    {
        $array = explode(',', $request->skills);
        $item = Item::create([
        'name' => $request->name,
        ]);

        $cantidadCategorias = count($array);
        for($i = 0; $i < $cantidadCategorias; $i++){
            $category = \DB::table('categories')->where('name', $array[$i])->first();
            $insert = \DB::table('category_item')->insert(
                ['id_item' => (string)$item->id, 'id_category' => (string)$category->id]
            );
        }

         return response()->json(['success'=>'Product saved successfully.']);
    }

    //Funciòn para eliminar color
    public function destroy(Request $request)
    {
        $id = $request->id;
        $item = \DB::table('items')->where('id', '=', $id)->delete();
        $item = \DB::table('category_item')->where('id_item', '=', $id)->delete();
        return response()->json(['success'=>'Product deleted successfully.']);
        
    }
}
