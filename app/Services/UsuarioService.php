<?php

namespace App\Services;

use App\Models\estadoTarea;
use App\Models\materias;
use App\Models\tareas;
use App\Models\tbm_usuario;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Support\Facades\DB; 

class UsuarioService
{
    /**
     *
     * @param string $usuario
     * @param string $cedula
     * @return array
     */
    public function obtenerContraseñaPorUsuarioYCedula(string $usuario, string $cedula)
    {
        try {
            $usuarioData = tbm_usuario::where('usuario', $usuario)
            ->where('estado', 'A')
            ->first();
            if ($usuarioData) {
                return  $usuarioData;
            } else {
                return ['error' => 'Usuario no encontrado'];
            }

        } catch (QueryException $e) {
            return ['error' => 'Error al consultar los usuarios: ' . $e->getMessage()];
        }
    }
    
    public function registrarUsuario($data): JsonResponse
    {
        try {
            $usuario = tbm_usuario::where('usuario', $data['usuario'])->first();

            if ($usuario) {
                return response()->json(['error' => 'El usuario ya está registrado.'], 409);
            }
            $nuevoUsuario = tbm_usuario::create([
                'usuario' => $data['usuario'], 
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'cedula' => $data['cedula'],
                'contraseña' => $data['contraseña'],  
                'correo' => $data['correo'],
                'estado' => 'A',
                'fecha_creacion' => now(),
            ]);
            return response()->json(['message' => 'Usuario registrado con éxito'], 200);
        } catch (Exception $e) {
            Log::error('Error al registrar usuario: ' . $e->getMessage());
            return response()->json(['error' => 'Ha ocurrido un error inesperado: ' . $e->getMessage()], 500);
        }
    }

    public function actualizarUsuario($data): JsonResponse
    {
        try {
            $usuario = tbm_usuario::where('id_usuario', $data['id_usuario'])->first();
            if (!$usuario) {
                return response()->json(['error' => 'Usuario no encontrado.'], 404);
            }
    
            $datosAActualizar = [];
            if (!empty($data['usuario'])) {
                $datosAActualizar['usuario'] = $data['usuario'];
            }
    
            if (!empty($data['nombre'])) {
                $datosAActualizar['nombre'] = $data['nombre'];
            }
    
            if (!empty($data['apellido'])) {
                $datosAActualizar['apellido'] = $data['apellido'];
            }
    
            if (!empty($data['cedula'])) {
                $datosAActualizar['cedula'] = $data['cedula'];
            }
    
            if (!empty($data['contraseña'])) {
                $datosAActualizar['contraseña'] =$data['contraseña'];
            }
    
            if (!empty($data['correo'])) {
                $datosAActualizar['correo'] = $data['correo'];
            }
    
            if (!empty($data['estado'])) {
                $datosAActualizar['estado'] = $data['estado'];
            }
            $datosAActualizar['fecha_actualizacion'] = now();
            if (!empty($datosAActualizar)) {
                tbm_usuario::where('id_usuario', $data['id_usuario'])->update($datosAActualizar);
                return response()->json(['message' => 'Usuario actualizado con éxito'], 200);
            } else {
                return response()->json(['message' => 'No hay datos para actualizar.'], 400);
            }
        } catch (Exception $e) {
            Log::error('Error al actualizar usuario: ' . $e->getMessage());
            return response()->json(['error' => 'Ha ocurrido un error inesperado: ' . $e->getMessage()], 500);
        }
    }
    
    public function actualizarEstado($data): JsonResponse
    {
        try {
            if (!isset($data['tareas']) || !is_array($data['tareas'])) {
                return response()->json(['error' => 'Formato de datos inválido. Se esperaba un array de tareas.'], 400);
            }
            $actualizadas = [];
            $noEncontradas = [];
            foreach ($data['tareas'] as $tarea) {
                if (!isset($tarea['id_tarea']) || !isset($tarea['estado'])) {
                    continue;
                }
                $registro = tareas::find($tarea['id_tarea']);
                if ($registro) {
                    $registro->update([
                        'estado' => $tarea['estado'],
                        'fecha_actualizacion' => now(),
                    ]);
                    $actualizadas[] = $tarea['id_tarea'];
                } else {
                    $noEncontradas[] = $tarea['id_tarea'];
                }
            }
            if (count($actualizadas) > 0) {
                $response = [
                    'message' => 'Tareas actualizadas con éxito.',
                    'actualizadas' => $actualizadas,
                ];
    
                if (count($noEncontradas) > 0) {
                    $response['no_encontradas'] = $noEncontradas;
                }
    
                return response()->json($response, 200);
            } else {
                return response()->json([
                    'message' => 'No se encontraron tareas para actualizar.',
                    'no_encontradas' => $noEncontradas,
                ], 404);
            }
        } catch (Exception $e) {
            Log::error('Error al actualizar tareas: ' . $e->getMessage());
            return response()->json([
                'error' => 'Ha ocurrido un error inesperado: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function eliminartarea($data): JsonResponse
    {
        try {
            $registro = Tareas::find($data);
            if (!$registro) {
                return response()->json([
                    'message' => 'Tarea no encontrada.',
                    'no_encontradas' => $data,
                ], 404);
            }
            $registro->update([
                'estado' => 4,
                'fecha_actualizacion' => now(),
            ]);
            return response()->json([
                'message' => 'Se elimino la tarea.',
                'tarea' => $registro,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error al actualizar el estado de la tarea: ' . $e->getMessage());
            return response()->json([
                'error' => 'Ha ocurrido un error inesperado: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function obtenerTodasLasMaterias(): JsonResponse
    {
        try {
            $materias = materias::where('estado', 'A')->get();
            return response()->json([
                'success' => true,
                'data' => $materias
            ], 200);
        } catch (QueryException $e) {
            Log::error('Error al obtener las materias: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener las materias: ' . $e->getMessage()
            ], 500);
        }
    }
    public function obtenerestados(): JsonResponse
    {
        try {
            $materias = estadoTarea::where('estado', 'A')->get();
            return response()->json([
                'success' => true,
                'data' => $materias
            ], 200);
        } catch (QueryException $e) {
            Log::error('Error al obtener los estados: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener los estados: ' . $e->getMessage()
            ], 500);
        }
    }
    public function registrarTarea($data): JsonResponse
    {
        try {
            $usuario = tareas::where('titulo', $data['titulo'])->first();
            if ($usuario) {
                return response()->json(['error' => 'La tarea ya está registrada.'], 409);
            }
            $nuevoUsuario = tareas::create([
                'titulo' => $data['titulo'], 
                'descripcion' => $data['descripcion'],
                'materia' => $data['id_materia'],
                'fecha_incio' => $data['fechaInicio'],  
                'fecha_fin' => $data['fechaFin'],
                'estado' => '2',
                'fecha_creacion' => now(),
            ]);
            return response()->json(['message' => 'Tarea registrada con éxito'], 200);
        } catch (Exception $e) {
            Log::error('Error al registrar la tarea: ' . $e->getMessage());
            return response()->json(['error' => 'Ha ocurrido un error inesperado: ' . $e->getMessage()], 500);
        }
    }
    public function reporTareas($tarea = null, $materia = null, $estado = null, $fechaInicio = null, $fechaFin = null)
    {
        try {
            $query = tareas::join('tbm_materia as m', 'm.id_materia', '=', 'tbm_tareas.materia')
                ->join('tbm_estado_tareas as et', 'et.id_estado_tareas', '=', 'tbm_tareas.estado')
                ->select(
                    'tbm_tareas.*',
                    'm.descripcion as materia_des',
                    'et.descripcion as estado_tarea'
                )
                ->where('et.estado', 'A'); 
    
            if (!empty($tarea)) {
                $query->where('tbm_tareas.titulo', 'LIKE', '%' . $tarea . '%');
            }
    
            if (!empty($materia)) {
                $query->where('m.id_materia',  '=',$materia );
            }
    
            if (!empty($estado)) {
                $query->where('et.id_estado_tareas','=', $estado);
            }
    
            if (!empty($fechaInicio) && !empty($fechaFin)) {
                $fechaFin = date('Y-m-d 23:59:59', strtotime($fechaFin)); 
                $query->whereBetween('tbm_tareas.fecha_creacion', [$fechaInicio, $fechaFin]);
            }
            $query->orderBy('et.id_estado_tareas', 'asc');
            $resultado = $query->get();
            if ($resultado->isNotEmpty()) {
                return $resultado;
            } else {
                return ['error' => 'No se encontraron resultados con los filtros proporcionados'];
            }
        } catch (\Exception $e) {
            Log::error('Error al ejecutar el reporte: ' . $e->getMessage());
            return ['error' => 'Error al ejecutar el reporte: ' . $e->getMessage()];
        }
    }
    
    
    
    
}
