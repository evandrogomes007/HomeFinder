<?php $__env->startSection('title', 'Entrar — HomeFinder'); ?>

<?php $__env->startSection('content'); ?>

<div style="min-height:calc(100vh - 68px); display:flex; align-items:center; justify-content:center; padding:40px 16px; background:linear-gradient(135deg, #111827 0%, #1F2937 60%, #111827 100%);">

    <div style="width:100%; max-width:420px;">

        
        <div style="text-align:center; margin-bottom:28px;">
            <a href="<?php echo e(route('HomeFinder')); ?>" style="font-family:var(--font-h); font-size:1.8rem; font-weight:900; color:#fff; display:inline-block; margin-bottom:8px;">
                Home<span style="color:var(--brand);">Finder</span>
            </a>
            <p style="font-size:.82rem; color:rgba(255,255,255,.4);">Bem-vindo de volta à plataforma</p>
        </div>

        <div class="card" style="border:1px solid rgba(255,255,255,.07); background:var(--white);">

            <p class="card-eyebrow">Acesso seguro</p>
            <h2 class="card-title">Entrar na conta</h2>
            <p class="card-sub">Insira as suas credenciais para continuar.</p>

            <form action="<?php echo e(route('auth.login')); ?>" method="POST" novalidate>
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label class="form-label" for="email">Endereço de email</label>
                    <input id="email" type="email" name="email"
                           value="<?php echo e(old('email')); ?>"
                           placeholder="o_seu@email.com"
                           autocomplete="email"
                           style="<?php echo e($errors->has('email') ? 'border-color:var(--brand);' : ''); ?>"
                           required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Palavra-passe</label>
                    <input id="password" type="password" name="password"
                           placeholder="••••••••"
                           autocomplete="current-password"
                           required>
                </div>

                <button type="submit" class="btn btn-brand" style="margin-top:22px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Entrar
                </button>
            </form>

            <?php if($errors->any()): ?>
                <div class="alert" style="margin-top:16px;">
                    <p class="alert-title">Não foi possível entrar</p>
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <hr class="divider">

            <p class="link-row">
                Não tem conta? <a href="<?php echo e(route('clientes.create')); ?>">Registar agora →</a>
            </p>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('homefinder', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/evandro/Documentos/HomeFinder_v2_estrutura_imobiliaria/resources/views/pages/login.blade.php ENDPATH**/ ?>