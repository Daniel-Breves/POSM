<?php
require_once 'shield.php';
include("conect.php");

$id_usuario = $_SESSION['usuario_id'];
$usuario = [];
$posming = [];

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

$usuario = $resultado->fetch_assoc();

$sql_posming = "SELECT * FROM posmings WHERE id_author = ?";
$stmt_posming = $conexao->prepare($sql_posming);
$stmt_posming->bind_param("i", $id_usuario);
$stmt_posming->execute();
$result_posming = $stmt_posming->get_result();
$posming = $result_posming->fetch_assoc();


//tentando fazer a soma total de pormings do usuario, mas ainda nao consegui
    $sql_total_posmings = "SELECT COUNT(id_posming) FROM posmings WHERE id_author = ?";
    $stmt_total = $conexao->prepare($sql_total_posmings);
    $stmt_total->bind_param("i", $id_usuario);
    $stmt_total->execute();
    $result_total = $stmt_total->get_result();
    $total_posmings = $result_total->fetch_assoc();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Gasoek+One&family=JetBrains+Mono:wght@300&display=swap" rel="stylesheet">
    <title>POSM | <?php echo htmlspecialchars($usuario['name']); ?> Profile</title>
    <style>
        body { font-family: 'JetBrains Mono', monospace; }
        h1, h2, h3, .font-gasoek { font-family: 'Gasoek One', sans-serif; }
        .text-shadow-glow { text-shadow: 0 0 15px rgba(255,255,255,0.3); }
    </style>
</head>
<body class="bg-black text-white selection:bg-white selection:text-black">

    <header class="fixed top-0 right-0 left-0 bg-black/90 border-b border-zinc-800 backdrop-blur-md z-50 flex flex-row justify-between items-center px-10 h-20">
        <div class="flex items-center gap-4">
            <a href="feed.html" class="flex items-center gap-4">
                <img class="w-12" src="front/assets/2.png" alt="POSM"> 
                <span class="font-gasoek text-2xl tracking-tighter">POSM</span>
            </a>
        </div>
        
        <nav class="hidden md:flex flex-row gap-12 text-[10px] uppercase tracking-[0.3em] font-bold items-center">
            <a class="transition hover:text-zinc-500" href="feed.html">The_Grid</a>
            <a class="text-white border-b border-white pb-1" href="profile.html">Identity_Node</a>
            <a href="logout.php">
            <button class="text-red-900 hover:text-red-500 transition cursor-pointer">Logout_</button>
            </a>
        </nav>
    </header>

    <main class="mt-32 max-w-4xl mx-auto px-6 pb-20">
        
        <section class="flex flex-col md:flex-row gap-10 items-center md:items-end border-b border-zinc-900 pb-16">
            
            <div class="relative group">
                <div class="w-40 h-40 bg-zinc-900 rounded-full border border-zinc-800 flex items-center justify-center overflow-hidden shadow-[0_0_30px_rgba(0,0,0,0.5)]">
                    <img src="front/assets/3.png" alt="Default Avatar" class="w-full h-full rounded-full opacity-80">
                </div>
                <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer">
                    <span class="text-[8px] uppercase tracking-tighter bg-black/80 p-2 border border-zinc-700">Update_Image</span>
                </div>
            </div>

            <div class="flex-grow text-center md:text-left">
                <div class="flex flex-col md:flex-row md:items-center gap-4 mb-4">
                    <h1 class="text-4xl uppercase tracking-tighter text-shadow-glow"><?php echo htmlspecialchars($usuario['name']); ?></h1>
                    <span class="text-[9px] border border-zinc-700 px-3 py-1 text-zinc-500 uppercase tracking-widest self-center md:self-auto">Level_01</span>
                </div>
                <p class="text-zinc-500 text-sm max-w-lg mb-6 leading-relaxed">
                    "Building the foundation of the Nexus Social Protocol. Logic is my only law."
                </p>
                <div class="flex gap-4 justify-center md:justify-start">
                    <button class="bg-white text-black font-gasoek px-6 py-2 text-xs hover:bg-zinc-300 transition cursor-pointer">
                        EDIT_IDENTITY
                    </button>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 py-12">
            <div class="border border-zinc-900 p-6 bg-zinc-950/30">
                <h4 class="text-[9px] text-zinc-700 uppercase tracking-widest mb-2">// Posmings</h4>
                <span class="font-gasoek text-2xl"></span>
            </div>
            <div class="border border-zinc-900 p-6 bg-zinc-950/30">
                <h4 class="text-[9px] text-zinc-700 uppercase tracking-widest mb-2">// Followers</h4>
                <span class="font-gasoek text-2xl text-shadow-glow">1.4k</span>
            </div>
            <div class="border border-zinc-900 p-6 bg-zinc-950/30">
                <h4 class="text-[9px] text-zinc-700 uppercase tracking-widest mb-2">// Joined_In</h4>
                <span class="font-gasoek text-2xl italic"><?php echo htmlspecialchars($usuario['created_at']); ?></span>
            </div>
        </section>

        <section class="mt-10 p-8 border border-zinc-900 bg-zinc-950/50 hidden">
            <h3 class="font-gasoek text-xl mb-8 tracking-tighter italic text-zinc-400">Modify_Core_Data</h3>
            <div class="flex flex-col gap-6 max-w-md">
                <div class="flex flex-col gap-2">
                    <label class="text-[9px] text-zinc-600 uppercase tracking-widest">New_Bio</label>
                    <textarea class="bg-black border border-zinc-800 p-4 text-xs font-mono text-zinc-400 focus:border-white outline-none resize-none" rows="3"></textarea>
                </div>
                <button class="border border-zinc-700 py-3 text-[10px] uppercase tracking-widest font-bold hover:bg-white hover:text-black transition">Update_Silo</button>
            </div>
        </section>

        <section class="w-full border border-zinc-800 bg-zinc-950 p-6 shadow-2xl relative overflow-hidden">
    
    <div class="absolute top-0 left-0 w-1 h-full bg-white/20"></div>

    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div class="w-2 h-2 bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.5)]"></div>
            <h2 class="font-gasoek text-xs tracking-[0.2em] uppercase">New_Posming</h2>
        </div>
        <span class="font-mono text-[9px] text-zinc-700 uppercase">Protocol: POSM_v1</span>
    </div>
    
    <form action="posming.php" method="POST" class="space-y-4">
        <div class="relative group">
            <textarea 
                name="content"
                maxlength="1000"
                required
                class="w-full bg-black border border-zinc-900 p-5 font-mono text-sm text-zinc-300 focus:border-zinc-500 outline-none min-h-[150px] resize-none transition-all placeholder:text-zinc-800"
                placeholder="Type your logic, insights or thoughts..."></textarea>
            
            <div class="absolute top-0 right-0 w-2 h-2 border-t border-r border-zinc-800 group-focus-within:border-white"></div>
            <div class="absolute bottom-0 left-0 w-2 h-2 border-b border-l border-zinc-800 group-focus-within:border-white"></div>
        </div>
        
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <span class="font-mono text-[9px] text-zinc-700">AUTHOR:</span>
                <span class="font-mono text-[9px] text-white underline underline-offset-4">@<?php echo htmlspecialchars($usuario['name']); ?></span>
            </div>

            <div class="flex items-center gap-6 w-full md:w-auto">
                <span id="char-count" class="font-mono text-[9px] text-zinc-700 uppercase tracking-tighter">0 / 1000</span>
                
                <button type="submit" class="w-full md:w-auto bg-white text-black font-gasoek px-12 py-4 text-sm hover:bg-zinc-300 transition-all duration-300 cursor-pointer shadow-[0_5px_15px_rgba(0,0,0,0.4)] active:scale-95">
                    EXECUTE_POSMING
                </button>
            </div>
        </div>
    </form>
</section>

        <section class="mt-12">
         <div class="flex items-center gap-4 mb-8">
        <h2 class="font-gasoek text-xl tracking-tighter uppercase">Posmings</h2>
        <div class="h-[1px] flex-grow bg-zinc-900"></div>
    </div>


    <div id="user-posmings-list" class="flex flex-col gap-4">
              <?php foreach ($result_posming as $posming): ?>
        <div class="border rounded-md border-zinc-900 bg-zinc-950/20 p-6 group hover:border-zinc-700 transition-all">
            <div class="flex justify-between items-start mb-4">
                <span class="font-mono text-[9px] text-zinc-600 uppercase tracking-widest">Signal_ID: <?php echo htmlspecialchars($posming['id_posming']); ?></span>
                <span class="font-mono text-[9px] text-zinc-700 italic"><?php echo htmlspecialchars($posming['created_at']); ?></span>
            </div>

            <p class="text-sm text-zinc-400 font-mono leading-relaxed mb-6">
                <?php echo htmlspecialchars($posming['content']); ?>
            </p>

            <div class="flex justify-between items-center border-t border-zinc-900/50 pt-4">
                <div class="flex gap-4">
                    <span class="font-mono text-[9px] text-zinc-600 uppercase">Status: <span class="text-green-900">Deployed</span></span>
                </div>
                
                <div class="flex gap-6">
                    <button class="font-mono text-[9px] text-zinc-700 hover:text-white uppercase transition cursor-pointer">Edit_</button>
                    <button class="font-mono text-[9px] text-zinc-700 hover:text-red-600 uppercase transition cursor-pointer font-bold">Delete_Sinal</button>
                </div>
            </div>
        </div>
         <?php endforeach; ?>
        </div>
 
</section>

    </main>

    <footer class="mt-auto border-t border-zinc-900 py-10 px-10 flex flex-col items-center">
        <button class="text-[9px] text-zinc-800 hover:text-red-900 transition tracking-[0.5em] uppercase mb-4">Terminate_Session</button>
        <p class="text-[8px] text-zinc-800 uppercase tracking-[0.8em]">Nexus Group // Zero Noise Protocol</p>
    </footer>

</body>
</html>