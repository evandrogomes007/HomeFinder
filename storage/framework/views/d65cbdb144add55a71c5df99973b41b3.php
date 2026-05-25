<?php $__env->startSection('title', 'Criar Conta — HomeFinder'); ?>

<?php $__env->startSection('content'); ?>

<div style="padding:52px 16px 80px; background:var(--gray-100);">
    <div style="max-width:520px; margin:0 auto;">

        
        <div style="text-align:center; margin-bottom:32px;">
            <span class="card-eyebrow" style="display:block;">Registo gratuito</span>
            <h1 style="font-family:var(--font-h); font-size:2rem; font-weight:900; color:var(--charcoal); margin-bottom:8px;">
                Crie a sua conta
            </h1>
            <p style="font-size:.88rem; color:var(--gray-600);">
                Aceda a milhares de imóveis ou publique o seu.
            </p>
        </div>

        <div class="card">

            <form action="<?php echo e(route('clientes.store')); ?>" method="POST" novalidate>
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label class="form-label" for="nome">Nome completo</label>
                    <input id="nome" type="text" name="nome"
                           value="<?php echo e(old('nome')); ?>"
                           placeholder="Ex: Maria da Silva"
                           autocomplete="name"
                           required>
                </div>

                <div class="input-row">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="genero">Género</label>
                        <select id="genero" name="genero" required>
                            <option value="" disabled <?php echo e(old('genero') ? '' : 'selected'); ?>>Selecionar</option>
                            <option value="masculino" <?php echo e(old('genero') == 'masculino' ? 'selected' : ''); ?>>Masculino</option>
                            <option value="feminino"  <?php echo e(old('genero') == 'feminino'  ? 'selected' : ''); ?>>Feminino</option>
                            <option value="outro"     <?php echo e(old('genero') == 'outro'     ? 'selected' : ''); ?>>Outro</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="telefone">Telefone</label>
                        <input id="telefone" type="tel" name="telefone"
                               value="<?php echo e(old('telefone')); ?>"
                               placeholder="9XX XXX XXX"
                               autocomplete="tel"
                               required>
                    </div>
                </div>

                <div class="form-group" style="margin-top:16px;">
                    <label class="form-label" for="email">Endereço de email</label>
                    <input id="email" type="email" name="email"
                           value="<?php echo e(old('email')); ?>"
                           placeholder="o_seu@email.com"
                           autocomplete="email"
                           required>
                </div>

                <div class="input-row">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="password">Palavra-passe</label>
                        <input id="password" type="password" name="password"
                               placeholder="Mín. 8 caracteres"
                               autocomplete="new-password"
                               required>
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="password_confirmation">Confirmar</label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               placeholder="Repita a senha"
                               autocomplete="new-password"
                               required>
                    </div>
                </div>

                <button type="submit" class="btn btn-brand" style="margin-top:26px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Criar conta grátis
                </button>
            </form>

            <?php if($errors->any()): ?>
                <div class="alert" style="margin-top:16px;">
                    <p class="alert-title">Corrija os seguintes erros</p>
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <hr class="divider">

            <p class="link-row">
                Já tem conta? <a href="<?php echo e(route('login')); ?>">Entrar →</a>
            </p>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('homefinder', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/evandro/Transferências/HomeFinder_v2_estrutura_imobiliaria/resources/views/pages/client-register.blade.php ENDPATH**/ ?>